<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Seeds the existing blog posts and their categories from the static site
 * (requirements MG1) and new blog entries. Keyed by slug so re-running never duplicates rows.
 */
class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $security = Category::query()->updateOrCreate(
            ['slug' => 'security'],
            ['name' => 'Security'],
        );

        $performance = Category::query()->updateOrCreate(
            ['slug' => 'performance'],
            ['name' => 'Performance'],
        );

        $developerTools = Category::query()->updateOrCreate(
            ['slug' => 'developer-tools'],
            ['name' => 'Developer Tools'],
        );

        $phpLaravel = Category::query()->updateOrCreate(
            ['slug' => 'php-laravel'],
            ['name' => 'PHP & Laravel'],
        );

        $posts = [
            [
                'category_id' => $security->id,
                'title' => 'A Practical Laravel Security Checklist Before You Launch',
                'slug' => 'laravel-security-checklist',
                'excerpt' => 'A practical, field-tested checklist for securing a Laravel application before launch — environment config, input validation, auth, HTTPS, and monitoring.',
                'cover_image' => 'https://picsum.photos/seed/laravel-security/800/600',
                'cover_image_alt' => 'Laravel Security Checklist',
                'body' => $this->laravelSecurityBody(),
                'status' => PostStatus::Published,
                'published_at' => Carbon::parse('2026-07-05'),
                'meta_description' => 'A practical, field-tested checklist for securing a Laravel application before launch — environment config, input validation, auth, HTTPS, and monitoring.',
            ],
            [
                'category_id' => $performance->id,
                'title' => 'Why Your WordPress Site Is Slow (And How I\'d Fix It)',
                'slug' => 'wordpress-speed-optimization',
                'excerpt' => 'The most common causes of slow WordPress sites — from bloated plugins to unoptimized images — and the fixes that make the biggest difference.',
                'cover_image' => 'https://picsum.photos/seed/wp-speed/800/600',
                'cover_image_alt' => 'WordPress Speed Optimization',
                'body' => $this->wordpressSpeedBody(),
                'status' => PostStatus::Published,
                'published_at' => Carbon::parse('2026-07-05'),
                'meta_description' => 'The most common causes of slow WordPress sites — from bloated plugins to unoptimized images — and the fixes that make the biggest difference.',
            ],
            [
                'category_id' => $developerTools->id,
                'title' => 'How to Set Up and Use GitHub SSH: A Step-by-Step Guide (2026)',
                'slug' => 'how-to-set-up-github-ssh',
                'excerpt' => 'Set up SSH authentication for GitHub on Linux or macOS in minutes — generate an Ed25519 key, add it to the SSH agent, register it with GitHub, and verify the connection.',
                'cover_image' => 'https://picsum.photos/seed/github-ssh/800/600',
                'cover_image_alt' => 'GitHub SSH Setup',
                'body' => $this->githubSshBody(),
                'status' => PostStatus::Published,
                'published_at' => Carbon::parse('2026-07-14'),
                'meta_description' => 'Set up SSH authentication for GitHub on Linux or macOS in minutes — generate an Ed25519 key, add it to the SSH agent, register it with GitHub, and verify the connection.',
            ],
            [
                'category_id' => $phpLaravel->id,
                'title' => 'How to Install Composer on Pop!_OS / Ubuntu (2026 Update)',
                'slug' => 'how-to-install-composer-popos-ubuntu',
                'excerpt' => 'Step-by-step guide to installing Composer on Pop!_OS or Ubuntu, with hash verification, so you can start managing PHP dependencies for Laravel, Symfony, and other projects.',
                'cover_image' => 'https://picsum.photos/seed/composer/800/600',
                'cover_image_alt' => 'Composer Setup',
                'body' => $this->composerBody(),
                'status' => PostStatus::Published,
                'published_at' => Carbon::parse('2026-07-14'),
                'meta_description' => 'Step-by-step guide to installing Composer on Pop!_OS or Ubuntu, with hash verification, so you can start managing PHP dependencies for Laravel, Symfony, and other projects.',
            ],
            [
                'category_id' => $phpLaravel->id,
                'title' => 'How to Create a UUID Generator with PHP (Plain PHP, Laravel & ramsey/uuid)',
                'slug' => 'create-uuid-generator-php',
                'excerpt' => 'Three ways to generate UUIDs in PHP: a dependency-free native function, the ramsey/uuid package, and Laravel\'s built-in Str::uuid() helper — with when to use each.',
                'cover_image' => 'https://picsum.photos/seed/uuid-php/800/600',
                'cover_image_alt' => 'PHP UUID Generator',
                'body' => $this->uuidBody(),
                'status' => PostStatus::Published,
                'published_at' => Carbon::parse('2026-07-14'),
                'meta_description' => 'Three ways to generate UUIDs in PHP: a dependency-free native function, the ramsey/uuid package, and Laravel\'s built-in Str::uuid() helper — with when to use each.',
            ],
        ];

        foreach ($posts as $post) {
            Post::query()->updateOrCreate(['slug' => $post['slug']], $post);
        }
    }

    private function laravelSecurityBody(): string
    {
        return <<<'HTML'
        <p>Over the past few years patching security issues on live client sites, I've noticed the same handful of gaps show up again and again — almost never anything exotic, usually just a default left unchanged or a check skipped under deadline pressure. This is the checklist I run through before any Laravel app goes live.</p>
        <h2>1. Lock down your environment file</h2>
        <p>Your <code>.env</code> file should never be reachable from the browser and should never be committed to version control. Confirm <code>APP_DEBUG</code> is set to false in production — a stray stack trace on a live error page can hand an attacker your database credentials and file paths without them lifting a finger.</p>
        <h2>2. Validate and sanitize every input</h2>
        <p>Laravel's form request validation makes this easy to get right, so there's rarely a good excuse to skip it. Validate on the way in, and use Eloquent or query bindings rather than raw queries to avoid SQL injection. Escape output in Blade templates by default, and be deliberate about the rare cases where you use unescaped output.</p>
        <h2>3. Keep dependencies current</h2>
        <p>Run <code>composer audit</code> regularly and subscribe to security advisories for any packages handling authentication, payments, or file uploads. A surprising number of the vulnerabilities I've patched traced back to an outdated package rather than custom code.</p>
        <h2>4. Harden authentication and sessions</h2>
        <p>Use Laravel's built-in hashing (bcrypt or argon2) — never roll your own. Set sensible session lifetimes, enable HTTPS-only cookies, and add rate limiting to login and password-reset routes so they can't be brute-forced.</p>
        <h2>5. Enforce HTTPS and security headers</h2>
        <p>Force HTTPS in production and add headers like Content-Security-Policy, X-Frame-Options, and X-Content-Type-Options. These are a few lines of middleware that close off a surprising number of common attack vectors.</p>
        <h2>6. Apply least-privilege database access</h2>
        <p>Your application's database user should only have the permissions it actually needs. If it doesn't run migrations in production, it doesn't need schema-altering privileges. This limits the blast radius if application-level access is ever compromised.</p>
        <h2>7. Log and monitor</h2>
        <p>Set up logging for failed login attempts and unusual activity, and make sure someone actually looks at those logs. The fastest way to limit damage from an incident is knowing about it quickly.</p>
        <p>None of this is exotic — it's mostly discipline applied consistently before launch. If you'd like a second pair of eyes on a Laravel app before it goes live, that's exactly the kind of work I take on.</p>
        HTML;
    }

    private function wordpressSpeedBody(): string
    {
        return <<<'HTML'
        <p>Most WordPress speed problems I run into on client audits come down to the same three or four causes. Here's the order I check them in, and what usually fixes each one.</p>
        <h2>1. Plugin bloat</h2>
        <p>Every active plugin adds its own scripts, styles and (often) database queries — whether or not the page actually needs them. I start by auditing which plugins run on every page versus which only need to load on specific ones, and disable or replace anything doing more than it should.</p>
        <h2>2. Unoptimized images</h2>
        <p>Full-resolution images uploaded straight from a phone or camera are one of the single biggest drags on load time. Serving properly sized, compressed images in modern formats (WebP where supported) with lazy loading for anything below the fold usually delivers the most visible improvement for the least effort.</p>
        <h2>3. No caching layer</h2>
        <p>WordPress generates pages dynamically by default, which means PHP and database work on every single visit unless something caches the output. A page-caching plugin, combined with server-level caching where possible, can cut load times dramatically without touching a single line of theme code.</p>
        <h2>4. Unoptimized database queries</h2>
        <p>Years of revisions, spam comments and transient options can bloat the database and slow every query down. A periodic cleanup, plus object caching with something like Redis for high-traffic sites, keeps things responsive as content grows.</p>
        <h2>5. Render-blocking scripts</h2>
        <p>Scripts and stylesheets loaded in the wrong order can delay the browser from painting anything at all. Deferring non-critical JavaScript and inlining critical CSS are small changes that measurably improve perceived load speed.</p>
        <h2>What this bought one client</h2>
        <p>On one e-learning platform I worked on, addressing these areas — alongside broader SEO work — contributed to a 40% increase in organic traffic, largely because faster pages and better technical SEO gave search engines less reason to rank the site lower.</p>
        <p>If your WordPress site feels sluggish and you're not sure why, I'm happy to take a look and tell you honestly what's worth fixing first.</p>
        HTML;
    }

    private function githubSshBody(): string
    {
        return Str::markdown(<<<'MD'
# How to Set Up and Use GitHub SSH: A Step-by-Step Guide

If you're tired of typing your GitHub username and a personal access token every time you push code, SSH is the fix. Once it's set up, `git push` and `git pull` just work — no prompts, no tokens to copy-paste, no expiring credentials to renew.

This guide walks through generating an SSH key, adding it to GitHub, and confirming everything works, on Linux or macOS.

## What You'll Need

- A terminal (Linux, macOS, or Git Bash/WSL on Windows)
- A GitHub account
- 5 minutes

## Step 1 — Check for an Existing SSH Key

You may already have one. Check before generating a new key:

```bash
ls -al ~/.ssh
```

If you see a pair of files like `id_ed25519` and `id_ed25519.pub`, you have a key already and can skip to Step 3. If the directory doesn't exist or is empty, move on to Step 2.

## Step 2 — Generate a New SSH Key

GitHub recommends the **Ed25519** algorithm — it's faster and just as secure as RSA, with a much shorter key.

```bash
ssh-keygen -t ed25519 -C "your_email@example.com"
```

Replace the email with the one tied to your GitHub account. You'll be prompted for:

- **A file location** — press Enter to accept the default (`~/.ssh/id_ed25519`).
- **A passphrase** — optional, but recommended. It protects your private key if your machine is ever compromised. You'll only need to type it once per session thanks to the SSH agent (next step).

## Step 3 — Add Your Key to the SSH Agent

The SSH agent holds your decrypted key in memory so you're not re-entering your passphrase constantly.

```bash
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/id_ed25519
```

On macOS, if you want the key to persist across reboots via Keychain:

```bash
ssh-add --apple-use-keychain ~/.ssh/id_ed25519
```

## Step 4 — Copy Your Public Key

You need the **public** key (`.pub` file) — never the private one.

```bash
cat ~/.ssh/id_ed25519.pub
```

Select and copy the full output, starting with `ssh-ed25519` and ending with your email.

On macOS you can copy it directly to the clipboard instead:

```bash
pbcopy < ~/.ssh/id_ed25519.pub
```

On Linux with `xclip` installed:

```bash
xclip -selection clipboard < ~/.ssh/id_ed25519.pub
```

## Step 5 — Add the Key to GitHub

1. Log in to GitHub and go to **Settings**.
2. In the sidebar, click **SSH and GPG keys**.
3. Click **New SSH key**.
4. Give it a descriptive title (e.g. "Work Laptop — Pop!_OS 2026") so you can identify it later if you ever need to revoke it.
5. Paste your public key into the **Key** field.
6. Click **Add SSH key**.

## Step 6 — Test the Connection

```bash
ssh -T git@github.com
```

The first time you connect, you'll see a fingerprint prompt asking whether to continue — type `yes`. If everything is configured correctly, you'll see:

```
Hi your-username! You've successfully authenticated, but GitHub does not provide shell access.
```

That message means it worked — GitHub doesn't offer an interactive shell over SSH, so seeing that response confirms authentication succeeded.

## Step 7 — Clone or Switch a Repo to SSH

For a new repository, use the SSH URL (starts with `git@github.com:`) instead of the HTTPS one when cloning:

```bash
git clone git@github.com:your-username/your-repo.git
```

For a repo you already cloned over HTTPS, switch its remote to SSH:

```bash
git remote set-url origin git@github.com:your-username/your-repo.git
```

Verify it took effect:

```bash
git remote -v
```

## Troubleshooting

**"Permission denied (publickey)"** — Your key likely isn't loaded in the agent, or isn't linked to your GitHub account. Run `ssh-add -l` to confirm the key is loaded, and double-check the public key was pasted correctly in GitHub's settings.

**Connections blocked on port 22** — Some networks (corporate VPNs, some ISPs) block SSH's default port. GitHub offers a workaround using port 443 — see [GitHub's official troubleshooting guide](https://docs.github.com/en/authentication/troubleshooting-ssh) if you hit this.

**Using multiple GitHub accounts on one machine** — You'll need a separate key per account and a `~/.ssh/config` file that maps each account to its own key. That's a bigger topic worth its own post if there's interest — let me know.

## Wrap-Up

That's it — SSH authentication set up end to end. It's a five-minute task that saves you from re-authenticating constantly, and it's one of those things worth doing on day one of any new machine setup.
MD
        );
    }

    private function composerBody(): string
    {
        return Str::markdown(<<<'MD'
# How to Install Composer on Pop!_OS / Ubuntu

Composer is the standard dependency manager for PHP. If you're setting up Laravel, Symfony, or really any modern PHP project, this is one of the first tools you'll install. This guide covers installing it on Pop!_OS or any Ubuntu-based distribution, with the official hash-verification step so you're not just trusting a random script.

## Prerequisites

You'll need:

- A Pop!_OS or Ubuntu system with terminal (sudo) access
- `git` and `curl` installed

Check whether you already have them:

```bash
git -v && curl -V
```

If either is missing:

```bash
sudo apt-get install git curl
```

## Step 1 — Install PHP CLI and Required Extensions

Composer needs `php-cli` to run, and `unzip` to extract package archives.

```bash
sudo apt update
sudo apt install php-cli unzip
```

Confirm the installation with `Y` when prompted.

## Step 2 — Download the Composer Installer

Composer installs itself using a small PHP script. Download it to a temporary location:

```bash
cd ~
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
```

## Step 3 — Verify the Installer

Don't skip this — it confirms the script you downloaded hasn't been tampered with. Composer publishes the expected hash at [getcomposer.org/download](https://getcomposer.org/download/); fetch it programmatically and compare:

```bash
HASH=$(curl -sS https://composer.github.io/installer.sig)
php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified' . PHP_EOL; } else { echo 'Installer corrupt' . PHP_EOL; unlink('/tmp/composer-setup.php'); }"
```

You should see:

```
Installer verified
```

If you see `Installer corrupt` instead, delete the file and re-download it — don't proceed with a script that fails verification.

## Step 4 — Install Composer Globally

This installs Composer as a system-wide `composer` command:

```bash
sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

You should see output confirming the install, ending with something like:

```
Composer (version 2.x.x) successfully installed to: /usr/local/bin/composer
Use it: php /usr/local/bin/composer
```

## Step 5 — Verify the Installation

```bash
composer --version
```

You'll see Composer's ASCII logo and its version number printed — confirmation it's installed and available from anywhere on your system.

## Step 6 — Clean Up

Remove the temporary installer script now that it's no longer needed:

```bash
rm /tmp/composer-setup.php
```

## Common Issues

**`composer: command not found`** — Check that `/usr/local/bin` is in your `PATH`: `echo $PATH`. If it's missing, add `export PATH="/usr/local/bin:$PATH"` to your `~/.bashrc` and reload with `source ~/.bashrc`.

**Permission errors during install** — Make sure you're running Step 4 with `sudo`, since it writes to `/usr/local/bin`, a system directory.

**Wrong PHP version picked up** — If you have multiple PHP versions installed, `php-cli` might not point at the one you expect. Run `php -v` to check, and use `update-alternatives --config php` to switch if needed.

## What's Next

With Composer installed, you're ready to scaffold a new project:

```bash
composer create-project laravel/laravel my-app
```

Or add Composer as a dependency manager to an existing PHP project by running `composer init` in its root directory.
MD
        );
    }

    private function uuidBody(): string
    {
        return Str::markdown(<<<'MD'
# How to Create a UUID Generator with PHP

A UUID (Universally Unique Identifier) is a 128-bit value used to uniquely identify a record — a user, an order, an API resource — without relying on an auto-incrementing database ID. They're especially useful when you need IDs that are safe to generate client-side, hard to guess, or unique across multiple systems that don't share a database.

This post covers three ways to generate one in PHP, from no dependencies at all to Laravel's built-in helper.

## What a UUID Looks Like

A standard UUID (version 4, the random variant) looks like this:

```
d290f1ee-6c54-4b01-90e6-d701748f0851
```

36 characters: 32 hex digits, 4 hyphens, and a couple of fixed bits that mark it as version 4.

## Option 1 — Plain PHP, No Dependencies

If you just need a UUID v4 and don't want to add a package for it, you can generate one with PHP's built-in `random_bytes()`:

```php
function generateUuidV4(): string
{
    $data = random_bytes(16);

    // Set version to 0100 (UUID v4)
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10 (variant RFC 4122)
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

echo generateUuidV4();
// e.g. 6f9619ff-8b86-d011-b42d-00cf4fc964ff
```

This is fine for most use cases — it's cryptographically random and RFC 4122-compliant. The tradeoff is you're maintaining the implementation yourself, and it only covers v4. If you need other UUID versions (v1 time-based, v5 name-based, etc.), reach for a package instead.

## Option 2 — The `ramsey/uuid` Package

For anything beyond basic v4 generation — or if you just don't want to own that function — `ramsey/uuid` is the standard PHP library for this.

Install it:

```bash
composer require ramsey/uuid
```

Use it:

```php
use Ramsey\Uuid\Uuid;

$uuid4 = Uuid::uuid4();
echo $uuid4->toString();

// Other versions are available too:
$uuid1 = Uuid::uuid1();   // time-based
$uuid5 = Uuid::uuid5(Uuid::NAMESPACE_URL, 'https://ohene.dev'); // name-based, deterministic
```

`uuid5` is worth knowing about specifically — it generates the *same* UUID every time for the same namespace + name input, which is useful when you want a stable, unique ID derived from something like a URL or email address.

## Option 3 — Laravel's Built-In Helper

If you're already in a Laravel app, you don't need a package at all — Laravel ships with UUID generation via its `Str` helper (which itself wraps `ramsey/uuid` under the hood):

```php
use Illuminate\Support\Str;

$uuid = Str::uuid();
echo $uuid->toString();
```

### Using UUIDs as Primary Keys in Eloquent

If you want a model to use UUIDs instead of auto-incrementing IDs, add the `HasUuids` trait (Laravel 9+):

```php
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Order extends Model
{
    use HasUuids;
}
```

And in your migration, define the column as a UUID rather than an integer:

```php
$table->uuid('id')->primary();
```

Laravel will then generate a UUID automatically whenever a new `Order` is created — no manual assignment needed.

## Which Option Should You Use?

| Situation | Recommended approach |
|---|---|
| Quick script, no framework, no dependencies wanted | Plain PHP function (Option 1) |
| Non-Laravel PHP project needing multiple UUID versions | `ramsey/uuid` (Option 2) |
| Laravel project | Built-in `Str::uuid()` / `HasUuids` (Option 3) |

## A Note on UUIDs vs Auto-Increment IDs

UUIDs aren't free — they're larger (16 bytes vs 4-8 for integers), which means bigger indexes and slightly slower joins at scale. They're the right call when you need IDs that are unguessable, generated outside the database, or unique across multiple services. For a typical single-database CRUD app with no external ID generation requirement, auto-incrementing integers are often still the simpler, faster default.
MD
        );
    }
}
