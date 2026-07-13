# Requirements Document
## Ohene Adjei Effah — Portfolio & Client Acquisition Site (Dynamic Version)

**Version:** 1.0
**Owner:** Ohene Adjei Effah
**Prepared by:** Claude (design/marketing/SEO consultant)
**Status:** Draft for review

---

## 1. Purpose & Goals

This site's primary job is **business development**, not resume display. It exists to:

1. Convince a prospective client, within one scroll, that Ohene can solve their problem.
2. Provide evidence (case studies, testimonials, writing) that reduces the risk of hiring an unfamiliar freelancer.
3. Capture and track leads instead of losing them to a generic mailbox.
4. Build long-term organic search visibility through content (blog) and structured, indexable case studies.

**Out of scope for v1:** e-commerce/payments, client portal/login, multi-author CMS, multilingual support.

### Success metrics (KPIs)

| Metric | Target (6 months post-launch) |
|---|---|
| Organic search sessions/month | Baseline + 50% |
| Contact form submissions/month | ≥ 5 qualified leads |
| Blog posts published | ≥ 1/month |
| Avg. page load (LCP) | < 2.5s on 4G |
| Core Web Vitals | Pass on all templates |
| Indexed pages in Google Search Console | 100% of published posts/projects within 7 days |

---

## 2. Audience & Positioning

**Primary audience:** small-to-mid-size business owners, startup founders, and agency leads who need a Laravel/React/WordPress developer but don't have in-house engineering judgment to vet one.

**Secondary audience:** recruiters/hiring managers evaluating for full-time roles.

**Positioning statement:** *"A full-stack developer who ships production software and stays accountable after launch — not just a coder for hire."*

**Voice:** direct, plain-language, no jargon-for-its-own-sake. Confidence backed by specifics (numbers, named technologies), not adjectives.

---

## 3. Information Architecture

```
/                    Home — pitch + previews, links out
/services            (section on Home, anchor-linked; own page if service-specific SEO becomes a priority)
/work                Case study listing
/work/{slug}         Individual case study
/about               Bio, track record, skills, education
/blog                Post listing
/blog/{slug}         Individual post
/videos              Video gallery
/contact             Contact form + direct links
/sitemap.xml         Generated
/rss.xml             Blog feed
```

Every content page (post, project, testimonial) must resolve to a **stable, unique, human-readable URL slug**.

---

## 4. Design Requirements

### 4.1 Design system (carry over from static build)
- **Colors:** ink `#0D1420`, gold `#D9A441`, forest `#2F6F4E`, rust `#B0472E`, linen `#EEF1EF` — defined once in a shared Tailwind config/theme file, not per-page.
- **Type:** Space Grotesk (display), IBM Plex Sans (body), IBM Plex Mono (labels/code/stats).
- **Signature motif:** Kente-weave diagonal divider between sections; terminal/file-path (`~/section`) framing for section eyebrows.
- **Components to formalize as reusable Blade/React components:** nav, footer, service card, case-study card, browser-mock visual, blog card, testimonial card, process step, proof-stat.

### 4.2 Responsive & accessibility requirements
- Mobile-first; test at 375px, 768px, 1280px breakpoints minimum.
- WCAG 2.1 AA contrast on all text.
- All interactive elements keyboard-navigable; visible focus states.
- `prefers-reduced-motion` respected for scroll-reveal animations.
- Images require `alt` text (enforced at CMS level — see 6.4).

### 4.3 Design-in-CMS constraint
Whoever writes a blog post or adds a project should **not** be able to break the design. This means:
- Rich text editor restricted to a safe subset (headings, bold/italic, lists, links, images, blockquote, code) — no arbitrary HTML/inline styles.
- Cover images cropped/validated to a fixed aspect ratio on upload.

---

## 5. Content Requirements

### 5.1 Blog
- Minimum viable post fields: title, slug, excerpt, body, cover image, category, read time (auto-calculated from word count), status (draft/published/scheduled), published date, author (fixed to Ohene for v1).
- SEO fields per post: meta title, meta description, canonical URL (auto), OG image (falls back to cover image).
- Related posts block at the end of each article (same category, 2–3 items) to reduce bounce and increase pages/session.

### 5.2 Work / Case studies
- Required fields: title, slug, one-line tagline, challenge, build, impact, tech stack (tags), cover/mockup image, live URL (optional), repo URL (optional), featured flag (controls Home page preview), display order.
- Each case study must state a **quantified outcome** wherever real data exists (already true for the 3 seed projects — enforce this standard for future ones too).
- Prev/next navigation between case studies (already implemented in static version — retain).

### 5.3 Testimonials
- Fields: client name, role, company, quote, avatar (optional), linked project (optional), status (pending/approved).
- Submissions can come from a simple form sent to past clients; nothing goes live without manual approval.
- At least **one real testimonial before launch** — non-negotiable; the placeholder currently on the static site is not a shippable state for the dynamic version.

### 5.4 Videos
- Fields: title, YouTube video ID, description, thumbnail (auto-pulled from YouTube), published date.
- No self-hosted video files — embed only, to avoid bandwidth/storage cost.

### 5.5 Leads (contact form)
- Fields captured: name, email, message, project type (dropdown), budget range (dropdown, optional), source/UTM parameters, submitted date, status (new/contacted/won/lost).
- Auto-reply email to the submitter confirming receipt and expected response time.
- Notification email/Slack ping to Ohene on every new submission.
- Basic spam protection (honeypot field + rate limiting; avoid CAPTCHAs that hurt conversion unless spam becomes a real problem).

---

## 6. Functional Requirements

### 6.1 Public site
- FR1: All pages render fully server-side (no content hidden behind client-side JS execution) for SEO and fast first paint.
- FR2: Blog and Work listings paginate (or lazy-load) once post/project count exceeds ~9 items per page.
- FR3: Search is not required for v1 given low content volume; revisit once blog exceeds ~20 posts.
- FR4: 404 page matches site design and links back to Home, Work, and Blog.
- FR5: Contact form submits via POST, validates server-side, and does not reload to a blank page (inline success/error state).

### 6.2 Admin / CMS
- FR6: Single authenticated admin user for v1 (Ohene). No multi-role permission system needed yet.
- FR7: CRUD interface for Posts, Projects, Testimonials, Videos, Settings, and read-only view of Leads.
- FR8: "Available for new projects" toggle exposed as an editable setting (currently hardcoded in the static hero).
- FR9: Draft/preview capability — view an unpublished post/project as it will appear live before publishing.
- FR10: Image upload with automatic resizing/compression on upload (no manually pre-optimized images required from the admin).

### 6.3 SEO (technical)
- FR11: `sitemap.xml` auto-regenerates on publish/update of any post or project, including `lastmod`.
- FR12: `robots.txt` present and correctly configured (allow all, point to sitemap).
- FR13: Per-page `<title>`, meta description, canonical tag, Open Graph and Twitter Card tags — populated from CMS fields with sensible auto-generated fallbacks if left blank.
- FR14: Structured data (JSON-LD) rendered per page type: `Person`/`ProfessionalService` (Home), `ItemList` (Work index), `CreativeWork` (case study), `BlogPosting` (post), `ContactPage` (Contact).
- FR15: 301 redirect table for any slug that changes post-publish, to avoid losing indexed URLs.
- FR16: RSS feed for the blog at `/rss.xml`.

### 6.4 Content quality gates (enforced in CMS, not just convention)
- FR17: Publish action blocked if: meta description is empty, cover image has no alt text, or slug is empty.
- FR18: Slug auto-generated from title but editable before first publish; locked (with redirect-on-change) after.

---

## 7. Marketing & Conversion Requirements

- MR1: Every page must have exactly one primary call-to-action visible without excessive scrolling ("Start a project" / "Contact").
- MR2: Contact form captures lead source (which page/campaign) via UTM parameters or referrer, stored on the `leads` record — required for measuring what's actually generating inquiries.
- MR3: Analytics installed (Google Analytics 4 or privacy-friendly alternative such as Plausible) with goal/event tracking on: contact form submit, resume download, outbound clicks to GitHub/LinkedIn.
- MR4: Testimonials surfaced on Home, and optionally on the specific case study they relate to.
- MR5: Newsletter/email capture is **not required for v1** — revisit once blog has enough regular traffic to justify the added complexity.

---

## 8. Technical Requirements

| Layer | Choice | Rationale |
|---|---|---|
| Backend framework | Laravel | Matches Ohene's professional stack; strong SEO story ("I built this on what I sell"); server-rendered by default |
| Admin/CMS | Filament | Fast to scaffold CRUD without building a custom admin from scratch |
| Frontend rendering | Blade + Tailwind | No SPA/hydration overhead; keeps first-paint fast |
| Database | MySQL | Consistent with Ohene's stated expertise |
| Image handling | Laravel + Intervention Image (or Spatie Media Library) | Auto-resize/compress on upload |
| Sitemap | `spatie/laravel-sitemap` | Auto-regeneration on content change |
| Hosting | AWS (EC2/RDS) or a managed Laravel host (Forge + DigitalOcean/AWS) | Matches Ohene's existing AWS familiarity |
| Email | Transactional email provider (e.g., Postmark/SES) for auto-replies and admin notifications | Deliverability better than default SMTP |

### 8.1 Data model summary

Tables required: `posts`, `categories`/`tags`, `projects`, `testimonials`, `videos`, `leads`, `settings`. Full column-level schema to be finalized at implementation time (see prior discussion for a first-pass field list per table).

### 8.2 Non-functional requirements
- NFR1: Page weight budget — under 500KB per page (excluding video embeds) to keep LCP under 2.5s.
- NFR2: Uptime target 99.5% (acceptable for a personal/portfolio site, not mission-critical infra).
- NFR3: Automated backups of the database (daily) and uploaded media.
- NFR4: HTTPS enforced site-wide; HSTS header enabled.
- NFR5: Admin panel behind authentication with rate-limited login attempts.

---

## 9. Migration Requirements (Static → Dynamic)

- MG1: All existing static content (3 case studies, 2 blog posts, resume PDF) seeded into the new database as the initial data set — no content regression at launch.
- MG2: Existing URLs (from the static site) must map 1:1 to new dynamic routes, or receive a 301 redirect, to preserve any accrued SEO value.
- MG3: Visual parity confirmed against the static build before cutover — same design system, same copy, same layout, functionally identical to the visitor.

---

## 10. Open Questions / Decisions Needed

1. Hosting budget and preference — AWS self-managed vs. managed platform (Laravel Forge, Vercel-for-Laravel alternatives)?
2. Real testimonial(s) — who will Ohene ask, and by when, ahead of launch?
3. YouTube channel — does it exist yet, or does the Videos section stay in "coming soon" state post-launch too?
4. Analytics tool preference — Google Analytics 4 vs. a privacy-first alternative (affects cookie-consent requirements)?
5. Domain/email — is `ohene.dev` plus a matching mailbox already set up for transactional email (SPF/DKIM)?

---

## 11. Phased Rollout

| Phase | Scope |
|---|---|
| **Phase 1 — Foundation** | Laravel install, data model, migrations, seed existing content, Filament admin, auth |
| **Phase 2 — Public templates** | Port all Blade views/components from static site, wire to real data |
| **Phase 3 — SEO & forms** | Sitemap, structured data, contact form + leads table, email notifications |
| **Phase 4 — QA & migration** | Cross-browser/device testing, redirect mapping, analytics install, content gate checks |
| **Phase 5 — Launch** | DNS cutover, monitor Search Console for indexing/errors |
| **Phase 6 — Post-launch** | Collect real testimonial(s), begin monthly blog cadence, revisit newsletter/search once traffic justifies it |

---

*This document defines requirements only. Visual mockups, database schema DDL, and API/route specifications are implementation artifacts to follow once this scope is approved.*
