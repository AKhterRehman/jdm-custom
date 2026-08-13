# Stripe webhook setup

The application accepts signed Stripe events at:

```text
https://YOUR-DOMAIN/stripe/webhook
```

For local testing with the Stripe CLI:

```bash
stripe listen --forward-to http://127.0.0.1:8000/stripe/webhook
```

Copy the `whsec_...` value printed by Stripe CLI (or supplied in the Stripe Dashboard) into the application environment:

```dotenv
STRIPE_WEBHOOK_SECRET=whsec_replace_with_your_endpoint_signing_secret
```

Do not use the publishable key or the Stripe API secret here. This value is the **Signing secret** for this exact webhook endpoint.

## Stripe Dashboard configuration

1. Open **Developers → Webhooks** in the same Stripe mode as your API keys (Test or Live).
2. Click **Add endpoint** and enter `https://YOUR-DOMAIN/stripe/webhook`.
3. Select these events:
   - `checkout.session.completed`
   - `checkout.session.async_payment_succeeded`
   - `checkout.session.async_payment_failed`
   - `checkout.session.expired`
4. Copy the endpoint's Signing secret to `STRIPE_WEBHOOK_SECRET`.
5. Deploy the application, then run `php artisan config:clear` on the server.
6. Use Stripe's **Send test webhook** button and confirm the response is HTTP `200` with body `ok`.

## What the webhook does

- A successful payment sets the order to `paid` and `processing`.
- An expired or failed session sets the order to `failed` and `cancelled`.
- Reserved product and variation stock is restored exactly once after a failed/expired payment.
- Duplicate Stripe deliveries are safe: the order row is locked and inventory is not adjusted twice.
