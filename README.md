# JDM Custom

A fully custom Laravel eCommerce platform for JDM performance parts and accessories, built per
the scope in [`docs/Custom eCommerce Website Development Proposal.pdf`](docs/Custom%20eCommerce%20Website%20Development%20Proposal.pdf).

## Tech Stack

- **Backend**: Laravel 13 (PHP 8.3)
- **Frontend**: Blade, Tailwind CSS, Vite
- **Auth**: Laravel Breeze (Blade stack)
- **Database**: MySQL

## Local Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
# create a MySQL database named jdm_custom, matching .env
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Seeded accounts:
- `test@example.com` / `password` — regular customer
- `admin@jdm-custom.test` / `password` — admin (`is_admin` flag set)

## Project Status

Built in phases — see the project board / task tracker for current progress. Completed so far:

- [x] Phase 0 — Laravel bootstrap, MySQL, Breeze auth, admin flag/middleware scaffold
- [x] Phase 1 — Catalog foundation: categories, products, variations, gallery, specs, storefront
- [x] Phase 2 — Cart, wishlist, checkout (coupons, shipping, tax), COD orders
- [ ] Phase 3 — Customer portal (addresses, order history/tracking)
- [ ] Phase 4 — Admin dashboard
- [ ] Phase 5 — Payment gateways (Stripe, PayPal, JazzCash, EasyPaisa)
- [ ] Phase 6 — SEO & marketing
- [ ] Phase 7 — Performance & security hardening
- [ ] Phase 8 — Newsletter, contact form, social/WhatsApp integration
- [ ] Phase 9 — Deployment & client documentation
