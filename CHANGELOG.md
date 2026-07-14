# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- `app/Helpers/AssetHelper.php` to resolve local public storage paths and external URLs for images.
- Social media sharing preview optimization using `$post->ogImage()` and `$project->ogImage()` on show pages instead of raw cover images.
- `CHANGELOG.md` following the Keep a Changelog format (per CLAUDE.md Section 1).
- Filament v5.6.8 admin panel (`filament/filament`), installed via `filament:install --panels`.
  Registers `App\Providers\Filament\AdminPanelProvider` (admin at `/admin`). Filament v5 is
  the release that supports Livewire 4, so no downgrade from the starter kit's Livewire 4.3 was needed.
- `spatie/laravel-sitemap` v8.2.0 for auto-regenerating `sitemap.xml` (requirement FR11).
- `intervention/image` v4.1.5 for on-upload image resize/compression (requirement FR10),
  paired with Filament's file uploads.
- `ThumbnailService` to automatically generate 600×450 thumbnail copies for fast loading, wired via the `GeneratesCoverThumbnail` Eloquent `saving` event hook. Thumbnails are automatically generated during database seeding (per CLAUDE.md architecture rules).

### Added — Phase 1 Foundation (data model, admin, seed data)
- **Domain models** with public ULIDs (bigint PK stays internal, per CLAUDE.md Section 5
  via the `HasPublicUlid` concern): `Category`, `Post`, `Project`, `Testimonial`, `Video`,
  `Lead`, plus a key/value `Setting`. Includes casts, relationships, and query scopes
  (`Post::published()`, `Project::featured()`/`ordered()`, `Testimonial::approved()`).
- **Enums** (string-backed, `app/Enums`): `PostStatus`, `TestimonialStatus`, `LeadStatus`,
  `ProjectType`, `BudgetRange`, each with `label()`/`color()` helpers.
- **Migrations** for all tables — bigint PK + unique ULID, indexed foreign keys and
  frequently-queried columns, money-free schema; enum-like columns stored as strings.
- **Filament v5 resources** for Posts, Projects, Categories, Testimonials, Videos, and a
  read-only Leads resource (FR7). Posts use a restricted rich-text toolbar so authors can't
  break the design (requirement 4.3); read time is auto-derived from the post body (5.1).
- **Policies** for every resource (`AdminPolicy` base + per-model classes); leads are
  create/delete-locked. `User` now implements `FilamentUser::canAccessPanel()` to gate the
  admin panel (NFR5).
- **Seeders** for the existing static content — 3 case studies and 2 blog posts with their
  categories — plus the "available for new projects" setting (FR8). Idempotent (keyed by slug),
  so no content regression at launch (MG1).
- **Factories** for all models and a suite of feature/unit tests (35 total) covering scopes,
  read-time calculation, ULID routing, enum helpers, seed data, and admin panel access.
- Enabled `RefreshDatabase` for feature tests and turned on Pint's `declare_strict_types`
  rule so `strict_types` is enforced across `app/` (CLAUDE.md Section 4).
- **Site settings page** (`ManageSiteSettings`, a single Filament page rather than key/value
  CRUD) exposing the "Available for new projects" toggle (FR8), gated by `canAccess()`.
- **Content-quality publish gate** (FR17): posts can't be published without a slug, a meta
  description, and alt text for any cover image — enforced on the model via a named
  `PostNotPublishableException` (Section 21) and surfaced in the admin form as validation.
- Added file/class/method docblocks to the generated Filament resource page classes to meet
  the documentation standard (Section 8).

### Added — Phase 2 Public templates (static site ported to Blade + real data)
- **Design system** ported into `resources/css/app.css` via Tailwind 4 `@theme` — brand
  colours (ink/gold/forest/rust/linen) and fonts (Space Grotesk / IBM Plex Sans / IBM Plex
  Mono) defined once (req 4.1), plus the signature circuit-trace divider and scroll-reveal
  CSS. Nav toggle + reveal moved to `resources/js/app.js` (no inline scripts, Section 11).
- **Base layout** (`x-layouts.app`) with per-page SEO title/description/canonical/OG meta,
  a shared `x-nav` (active-state aware) and `x-footer`.
- **Reusable Blade components** (req 4.1 / Section 10): `eyebrow`, `divider`, `browser-mock`,
  `service-card`, `case-study-card`, `blog-card`, `testimonial-card`, `process-step`,
  `proof-stat`. Card components share one file with a `compact` variant (DRY).
- **Public pages** wired to real data via thin controllers: home (featured work, latest
  posts, approved testimonials, availability toggle), work index (paginated) + case-study
  detail with prev/next, blog index (paginated) + post detail with related posts, about,
  videos (YouTube embeds, req 5.4), and contact (links + next steps; the lead form is Phase 3).
- **Slug-based public URLs** for posts and projects (`getRouteKeyName()` → slug) to preserve
  SEO and give 1:1 parity with the old static URLs (req Section 3, MG2); admin still uses ULID.
- **Styled 404** page matching the design, linking back to Home/Work/Blog (FR4).
- Added `@tailwindcss/typography` for post bodies; copied the résumé PDF into `public/`;
  ran `storage:link`. 12 feature tests cover every public route, slug binding, pagination,
  draft/404 handling, and prev/next. Aligned `composer types:check` to `--memory-limit=2G`.

### Added — Phase 3 SEO & forms
- **Contact form** — a class-based Livewire `ContactForm` (UI/orchestration only) backed by a
  `CreateLeadAction` (Section 9). Inline success/error + loading states (FR5), honeypot + IP
  rate limiting for spam control (5.5), and UTM/referrer capture onto the lead (MR2).
- **Lead email notifications** — `LeadSubmitted` event with two single-purpose queued
  listeners: an admin notification to Ohene and an auto-reply to the submitter (5.5). Both
  mailables are `ShouldQueue` on the `emails` queue (Section 15); recipient configurable via
  `config('mail.lead_recipient')` / `MAIL_LEAD_RECIPIENT`.
- **Sitemap** at `/sitemap.xml` (`spatie/laravel-sitemap`, built on the fly so it's always
  current) including every published post/project with `lastmod` (FR11); **robots.txt**
  updated to allow all, disallow `/admin`, and point at the sitemap (FR12); **RSS feed** at
  `/rss.xml` for the blog with an autodiscovery `<link>` in the layout (FR16).
- **JSON-LD structured data** per page type via an `x-json-ld` component and a `config/site.php`
  identity source (FR14): Person + ProfessionalService (home), ItemList (work index),
  CreativeWork (case study), BlogPosting (post), ContactPage (contact).
- **301 redirects + slug lock** (FR15/FR18) — a `redirects` table + `Redirect` model, a
  `RecordsSlugRedirects` concern (via the `RedirectsOnSlugChange` contract) that logs a
  redirect when a *published* post or a project changes its slug, chain-flattening included,
  and a 404 render hook in `bootstrap/app.php` that serves stored 301s.
- 19 feature tests cover the form (validation, honeypot, throttle, UTM, queued mail), sitemap,
  RSS, robots, JSON-LD, and redirect behaviour. Full suite: 68 tests green.

### Added — Phase 4 hardening & shared-hosting prep
- **Security headers** (`SecurityHeaders` middleware on the web group): `nosniff`,
  `X-Frame-Options: SAMEORIGIN`, `Referrer-Policy`, and HSTS over HTTPS; plus
  `URL::forceHttps()` in production (NFR4). CSP left as a tracked follow-up.
- **Lazy-loading prevention** (§17): `Model::preventLazyLoading()` — throws locally/staging,
  logs in production — with eager-loading fixes on the pages that needed them.
- **Shared-hosting queue**: the scheduler drains the queue every minute
  (`queue:work --stop-when-empty`), so a single Hostinger cron powers both the scheduler and
  queued emails — no daemon/Supervisor needed (§15).
- **Legacy 301s** (MG2): `LegacyRedirectSeeder` maps the old static `.html`/index URLs to the
  new routes, served through the existing redirect hook.
- **Analytics — Google Analytics 4 with cookie consent** (MR3): config-driven `x-analytics`
  seam (GA4 chosen; Cloudflare/Plausible also supported). GA4 is cookie-setting, so it's
  exposed as meta tags and **only loaded by `app.js` after the visitor accepts** the
  `x-cookie-consent` banner (choice stored in `localStorage`); cookieless providers skip the
  banner entirely. A `track()` helper wires contact-submit, résumé-download, and
  outbound-click events regardless of provider.
- **Email**: confirmed Brevo (free tier, SMTP) works with the existing mailables — config only.
- **`DEPLOY.md`**: Hostinger shared-hosting runbook (MySQL, document root, cron, env, Brevo,
  HTTPS, backups, post-deploy checks) with an ordered go-live checklist including DNS cutover
  and Search Console submission.
- **Testimonials on case studies** (MR4): approved testimonials linked to a project now show
  on that project's case-study page (pending ones stay hidden), eager-loaded to respect the
  lazy-loading guard.
- Full suite: 76 tests green.

### Added — requirement-gap closeout (pre-launch)
- **Draft preview** (FR9): admin-only `GET /blog/{post}/preview` renders any post (draft/
  scheduled) on the live template with a "Preview" ribbon; guests get a 404. A "Preview"
  header action on the post edit/view pages opens it in a new tab. Reuses the `show()` view.
- **Privacy policy** page at `/privacy` (plain-language: contact data, GA4 cookies-after-
  consent, third parties, retention). The cookie banner's "Learn more" and a new footer link
  now point to it — required for the GA4 consent flow.
- **Image handling** (FR10 / req 4.3): cover images auto-crop/resize to 16:9 (1200×675),
  OG images to 1200×630, testimonial avatars to 300×300, all with `maxSize` limits — uploads
  can't break the layout regardless of source file.
- **Admin actionable counts** (§18): a "new leads" navigation badge on the Leads resource and
  an eager `AdminStatsOverview` dashboard widget (new leads, pending testimonials, published
  posts, case studies).
- **Project cover alt text** now required whenever a cover image is set (req 4.2), matching
  the existing Post rule.
- Captured strategic design context in **PRODUCT.md** (`/impeccable init`): brand register,
  users, purpose, confident-craftsman personality, anti-references, principles, a11y.
- 8 new tests (preview access, privacy page, lead badge, dashboard widget, project alt-text
  validation). Full suite: 84 tests green.

### Fixed — design polish pass (accessibility & FR1)
- **Content no longer gated on JavaScript** (FR1 regression from earlier motion edits): the
  scroll-reveal is now scoped to a `.js` class set by `app.js`, so crawlers, no-JS, and
  failed-JS all get the fully visible page; the reveal only *enhances* when JS is present.
- **`prefers-reduced-motion` now honoured everywhere**: the animated hero aurora stops and the
  stat counter renders its final figure instantly for users who ask for reduced motion (§17 /
  WCAG 2.3.3).
- **Images lazy-load**: `loading="lazy"` + `decoding="async"` on card covers and avatars (with
  explicit avatar dimensions) to protect LCP/CLS (NFR1).
- **Removed all inline `style` attributes** (CLAUDE.md §11): the reveal stagger now uses
  Tailwind `delay-*` utilities; inert delay wrappers dropped.
- Footer social links given a larger touch target. Design context captured in DESIGN.md +
  `.impeccable/design.json` (`/impeccable document`). Audit score 14→ (re-run to confirm);
  full suite still 84 green.
