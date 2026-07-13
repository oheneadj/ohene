# Deployment — Hostinger Shared Hosting

This project is deployed to **Hostinger shared hosting** (not a VPS). That shapes a
few choices: no long-running queue daemon, no Supervisor, no Redis — the queue and
scheduler are driven by a single cron entry, and cache/session/queue all run on MySQL.

## 0. Go-live sequence (first launch)

Ordered checklist — each item links to the detailed section below.

- [ ] **1. MySQL** — create DB + user in hPanel (§1)
- [ ] **2. Upload code** outside `public_html`; set document root → `public/` (§1)
- [ ] **3. Dependencies** — `composer install --no-dev --optimize-autoloader` (§2)
- [ ] **4. `.env`** — production values, `php artisan key:generate`, DB, Brevo, GA4 (§3)
- [ ] **5. Assets** — `npm run build` locally, upload `public/build` (§2)
- [ ] **6. Migrate + seed** — `migrate --force`, `db:seed --force`, `storage:link` (§2)
- [ ] **7. Admin user** — `php artisan make:filament-user` (§2)
- [ ] **8. Cron** — add `* * * * * php artisan schedule:run` (§4)
- [ ] **9. Email** — verify the Brevo sending domain (SPF/DKIM) (§5)
- [ ] **10. SSL** — enable cert + force HTTPS (§6)
- [ ] **11. Optimise** — `config:cache && route:cache && view:cache` (§2)
- [ ] **12. DNS cutover** — point the domain at Hostinger; wait for propagation
- [ ] **13. Search Console** — verify domain, submit `/sitemap.xml`
- [ ] **14. Smoke test** — run the post-deploy checks (§8)

> For later releases, only steps 3, 5, 6 (migrate), and 11 apply — see §2.

## 1. One-time setup

### Database (MySQL)
1. In hPanel → **Databases → MySQL**, create a database + user and note the credentials.
2. Set these in the production `.env` (see section 3). Migrations are standard Blueprint
   and run on MySQL unchanged.

### Document root
Laravel must serve from the **`public/`** directory, never the project root.
- Preferred: point the domain's document root at `.../ohene/public` (hPanel → domain settings).
- If the host forces `public_html`, upload the app **outside** `public_html` and either
  symlink `public_html → ../ohene/public`, or move the contents of `public/` into
  `public_html` and adjust the paths in `public_html/index.php` to the app location.

### PHP version
Set PHP to **8.3+** in hPanel (matches `composer.json`). Ensure the `gd` (or `imagick`),
`pdo_mysql`, `mbstring`, `openssl`, and `zip` extensions are enabled — Intervention Image
needs GD/Imagick.

## 2. Deploy steps (each release)

From the project directory over SSH (Hostinger Business/Cloud plans include SSH):

```bash
git pull                              # or upload the build via SFTP
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link              # once, if not already linked
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Front-end assets:** run `npm run build` **locally** and commit/upload `public/build`
(Hostinger shared hosting has no reliable Node build step). Do **not** run `npm` on the server.

First deploy only, seed the base content + legacy redirects:

```bash
php artisan db:seed --force
php artisan make:filament-user        # create Ohene's admin login
```

## 3. Environment (`.env`)

Key differences from local:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ohene.dev

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=...        # from hPanel
DB_USERNAME=...
DB_PASSWORD=...

# Everything runs on the database (no Redis on shared hosting)
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Transactional email via Brevo (free tier, 300/day) — see below
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_SCHEME=tls
MAIL_USERNAME=...      # Brevo SMTP login
MAIL_PASSWORD=...      # Brevo SMTP key
MAIL_FROM_ADDRESS="hello@ohene.dev"
MAIL_LEAD_RECIPIENT="oheneadjei.dev@gmail.com"

# Analytics — Google Analytics 4 (a cookie-consent banner is shown automatically)
ANALYTICS_PROVIDER=ga4
ANALYTICS_GA4_ID=G-XXXXXXXXXX
```

`APP_KEY` must be set (`php artisan key:generate` once, then keep it stable).

## 4. Cron — scheduler + queue (required)

Shared hosting can't run `queue:work` as a daemon, so a single cron entry powers both
the scheduler and the queue (the scheduler dispatches `queue:work --stop-when-empty`
every minute — see `routes/console.php`). In hPanel → **Advanced → Cron Jobs**, add:

```
* * * * * cd /home/USER/domains/ohene.dev/ohene && php artisan schedule:run >> /dev/null 2>&1
```

Without this cron, contact-form emails (queued on the `emails` queue) will never send.

## 5. Email (Brevo)

1. Create a free Brevo account; generate an **SMTP key** (Senders & API → SMTP).
2. Add and verify the **`ohene.dev` sending domain** (SPF + DKIM DNS records) so mail
   lands in inboxes rather than spam.
3. Put the SMTP credentials in `.env` (section 3). No package needed — Laravel's built-in
   SMTP mailer handles it, and the existing queued mailables work unchanged.

## 6. HTTPS / security (NFR4)

- Enable the free SSL certificate in hPanel and force HTTPS at the server level
  (hPanel toggle or an `.htaccess` redirect). The app also sets `URL::forceHttps` in
  production and sends HSTS + `X-Frame-Options`/`nosniff`/`Referrer-Policy` headers
  (`App\Http\Middleware\SecurityHeaders`).

## 7. Backups (NFR3)

- Enable Hostinger's automatic backups, **and** schedule an independent daily DB dump
  (hPanel cron or a small scheduled command) plus periodic download of `storage/app/public`
  (uploaded media). Don't rely on a single backup location.

## 8. Post-deploy checks

- [ ] Home, work, blog, about, videos, contact all load over HTTPS
- [ ] `/sitemap.xml`, `/rss.xml`, `/robots.txt` return correctly
- [ ] Submit the contact form → lead appears in `/admin`, both emails arrive
- [ ] An old URL (e.g. `/work/inkbulksms.html`) 301s to the new route
- [ ] Submit `sitemap.xml` in Google Search Console; watch for indexing/errors
