<?php

namespace App\Services;

use App\Models\Address;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ShippoService
{
    private const BASE_URL = 'https://api.goshippo.com';

    /**
     * Get a live shipment quote for a cart, and auto-pick the cheapest standard/ground rate
     * across whichever carriers respond (UPS, USPS, FedEx). Throws on any API failure so the
     * caller can fall back to a flat rate.
     */
    public function quoteForCart(Address $address, Collection $cartItems): array
    {
        $parcel = $this->parcelForCart($cartItems);

        $response = $this->client()->post('/shipments/', [
            'address_from' => $this->fromAddress(),
            'address_to' => $this->toAddress($address),
            'parcels' => [$parcel],
            'async' => false,
        ]);

        if ($response->failed()) {
            throw new RuntimeException('Shippo shipment request failed: '.$response->body());
        }

        $shipment = $response->json();
        $rates = collect($shipment['rates'] ?? [])->filter(fn ($rate) => ($rate['amount'] ?? null) !== null);

        if ($rates->isEmpty()) {
            throw new RuntimeException('Shippo returned no rates for this address.');
        }

        $best = $this->pickBestRate($rates);

        return [
            'shipment_id' => $shipment['object_id'],
            'rate_id' => $best['object_id'],
            'amount' => (float) $best['amount'],
            'carrier' => $best['provider'],
            'service_level' => $best['servicelevel']['name'] ?? null,
        ];
    }

    /**
     * Purchase the label for a previously quoted rate.
     */
    public function purchaseLabel(string $rateId): array
    {
        $response = $this->client()->post('/transactions/', [
            'rate' => $rateId,
            'label_file_type' => 'PDF',
            'async' => false,
        ]);

        if ($response->failed()) {
            throw new RuntimeException('Shippo label purchase failed: '.$response->body());
        }

        $transaction = $response->json();

        if (($transaction['status'] ?? null) !== 'SUCCESS') {
            $messages = collect($transaction['messages'] ?? [])->pluck('text')->implode(' ');

            throw new RuntimeException('Shippo could not generate a label: '.($messages ?: 'unknown error'));
        }

        return [
            'transaction_id' => $transaction['object_id'],
            'label_url' => $transaction['label_url'],
            'tracking_number' => $transaction['tracking_number'],
            'tracking_url' => $transaction['tracking_url_provider'] ?? null,
        ];
    }

    private function pickBestRate(Collection $rates): array
    {
        $standardTokens = config('shipping.standard_service_tokens', []);

        $standard = $rates->filter(function ($rate) use ($standardTokens) {
            $token = strtolower($rate['servicelevel']['token'] ?? '');

            return in_array($token, $standardTokens, true);
        });

        $pool = $standard->isNotEmpty() ? $standard : $rates;

        return $pool->sortBy(fn ($rate) => (float) $rate['amount'])->first();
    }

    private function parcelForCart(Collection $cartItems): array
    {
        $weight = 0.0;
        $length = 0.0;
        $width = 0.0;
        $height = 0.0;

        foreach ($cartItems as $item) {
            $parcel = $item->product->shippingParcel();

            $weight += $parcel['weight_lbs'] * $item->quantity;
            $length = max($length, $parcel['length_in']);
            $width = max($width, $parcel['width_in']);
            $height += $parcel['height_in'] * $item->quantity;
        }

        return [
            'weight' => (string) round($weight, 2),
            'mass_unit' => 'lb',
            'length' => (string) round($length, 2),
            'width' => (string) round($width, 2),
            'height' => (string) round(max($height, 1), 2),
            'distance_unit' => 'in',
        ];
    }

    private function fromAddress(): array
    {
        $from = config('shipping.from_address');

        return [
            'name' => $from['name'],
            'street1' => $from['street1'],
            'city' => $from['city'],
            'state' => $from['state'],
            'zip' => $from['zip'],
            'country' => $from['country'],
            'phone' => $from['phone'],
            'email' => $from['email'],
        ];
    }

    private function toAddress(Address $address): array
    {
        return array_filter([
            'name' => $address->full_name,
            'street1' => $address->address_line1,
            'street2' => $address->address_line2,
            'city' => $address->city,
            'state' => $address->state,
            'zip' => $address->postal_code,
            'country' => $address->country ?: 'US',
            'phone' => $address->phone,
        ]);
    }

    private function client()
    {
        return Http::withToken(config('services.shippo.api_key'), 'ShippoToken')
            ->acceptJson()
            ->baseUrl(self::BASE_URL);
    }
}
