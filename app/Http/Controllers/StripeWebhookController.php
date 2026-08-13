<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderInventoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function __construct(private readonly OrderInventoryService $inventory)
    {
    }

    /**
     * Handle signed Stripe Checkout events for store orders.
     */
    public function handleWebhook(Request $request): Response
    {
        $secret = config('services.stripe.webhook_secret');

        if (blank($secret)) {
            Log::critical('Stripe webhook received without STRIPE_WEBHOOK_SECRET configured.');

            return response('Webhook secret is not configured.', 500);
        }

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                (string) $request->header('Stripe-Signature'),
                $secret,
            );
        } catch (\UnexpectedValueException|SignatureVerificationException $exception) {
            Log::warning('Rejected Stripe webhook.', ['message' => $exception->getMessage()]);

            return response('Invalid webhook signature.', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
            case 'checkout.session.async_payment_succeeded':
                $this->handlePaymentSucceeded($event->data->object);
                break;

            case 'checkout.session.expired':
            case 'checkout.session.async_payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;

            case 'payment_intent.payment_failed':
                // A Checkout Session may still be retried. Stock is released
                // only after Stripe sends the session failed/expired event.
                Log::warning('Stripe payment attempt failed.', [
                    'payment_intent_id' => $event->data->object->id,
                ]);
                break;

            default:
                Log::info('Unhandled Stripe webhook event.', ['type' => $event->type]);
        }

        return response('Webhook handled', 200);
    }

    /** Handle a completed and paid Stripe Checkout session. */
    private function handlePaymentSucceeded(object $session): void
    {
        if (($session->payment_status ?? null) !== 'paid') {
            return;
        }

        DB::transaction(function () use ($session) {
            $order = $this->findOrderForSession($session, true);

            if (! $order || $order->payment_status === 'paid') {
                return;
            }

            $order->update(['payment_status' => 'paid', 'status' => 'processing']);
            Log::info('Stripe order payment confirmed.', ['order_id' => $order->id, 'stripe_session_id' => $session->id]);
        });
    }

    /** Handle an expired or permanently failed Stripe Checkout session. */
    private function handlePaymentFailed(object $session): void
    {
        DB::transaction(function () use ($session) {
            $order = $this->findOrderForSession($session, true);

            if (! $order || $order->payment_status === 'paid') {
                return;
            }

            $stockReleased = $this->inventory->release($order);

            if ($stockReleased && $order->coupon_id) {
                $order->coupon()->decrement('used_count');
            }

            $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            Log::warning('Stripe order payment failed and stock was released.', ['order_id' => $order->id, 'stripe_session_id' => $session->id]);
        });
    }

    private function findOrderForSession(object $session, bool $lock = false): ?Order
    {
        $query = Order::query()->where('stripe_session_id', $session->id);

        if ($lock) {
            $query->lockForUpdate();
        }

        return $query->first();
    }
}
