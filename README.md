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

Stripe (test mode) needs `STRIPE_KEY` / `STRIPE_SECRET` set in `.env` — see `.env.example`.
Test card: `4242 4242 4242 4242`, any future expiry, any CVC.

## Project Status

Built in phases — see the project board / task tracker for current progress. Completed so far:

- [x] Phase 0 — Laravel bootstrap, MySQL, Breeze auth, admin flag/middleware scaffold
- [x] Phase 1 — Catalog foundation: categories, products, variations, gallery, specs, storefront
- [x] Phase 2 — Cart, wishlist, checkout (coupons, shipping, tax), COD orders
- [x] Phase 3 — Customer portal: account hub, saved addresses, order history/tracking
- [x] Phase 4 — Admin dashboard: analytics, products (+ gallery/specs/variations), categories,
      orders, customers, coupons, contact message inbox. Not yet built: banners, homepage
      content, blog, reviews, site settings (planned for later phases)
- [x] Premium redesign — Shop page, About/Contact/Privacy/Terms pages, category dropdown nav,
      order PDF/print receipts, image upload for product gallery, full visual overhaul
      (Lexend/Inter typography, dark header/footer, hero sections) across storefront, account,
      and admin
- [x] Phase 5 (partial) — Stripe Checkout wired up and working end-to-end (test mode); COD still
      available; PayPal/JazzCash/EasyPaisa shown at checkout as "coming soon", not yet functional
- [x] Mobile navigation — hamburger menu with collapsible categories
- [ ] Phase 6 — SEO & marketing
- [ ] Phase 7 — Performance & security hardening
- [ ] Phase 8 — Newsletter, social/WhatsApp integration
- [ ] Phase 9 — Deployment & client documentation
