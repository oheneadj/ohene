<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;

$blogs = [
    [
        'title' => "How to Set Up and Use GitHub SSH: A Step-by-Step Guide (2026)",
        'slug' => "how-to-set-up-github-ssh",
        'meta_description' => "Set up SSH authentication for GitHub on Linux or macOS in minutes — generate an Ed25519 key, add it to the SSH agent, register it with GitHub, and verify the connection.",
        'category' => "Developer Tools",
        'body' => <<<MARKDOWN
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
MARKDOWN
    ],
    [
        'title' => "How to Install Composer on Pop!_OS / Ubuntu (2026 Update)",
        'slug' => "how-to-install-composer-popos-ubuntu",
        'meta_description' => "Step-by-step guide to installing Composer on Pop!_OS or Ubuntu, with hash verification, so you can start managing PHP dependencies for Laravel, Symfony, and other projects.",
        'category' => "PHP & Laravel",
        'body' => <<<MARKDOWN
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
php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '\$HASH') { echo 'Installer verified' . PHP_EOL; } else { echo 'Installer corrupt' . PHP_EOL; unlink('/tmp/composer-setup.php'); }"
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

**`composer: command not found`** — Check that `/usr/local/bin` is in your `PATH`: `echo \$PATH`. If it's missing, add `export PATH="/usr/local/bin:\$PATH"` to your `~/.bashrc` and reload with `source ~/.bashrc`.

**Permission errors during install** — Make sure you're running Step 4 with `sudo`, since it writes to `/usr/local/bin`, a system directory.

**Wrong PHP version picked up** — If you have multiple PHP versions installed, `php-cli` might not point at the one you expect. Run `php -v` to check, and use `update-alternatives --config php` to switch if needed.

## What's Next

With Composer installed, you're ready to scaffold a new project:

```bash
composer create-project laravel/laravel my-app
```

Or add Composer as a dependency manager to an existing PHP project by running `composer init` in its root directory.
MARKDOWN
    ],
    [
        'title' => "How to Create a UUID Generator with PHP (Plain PHP, Laravel & ramsey/uuid)",
        'slug' => "create-uuid-generator-php",
        'meta_description' => "Three ways to generate UUIDs in PHP: a dependency-free native function, the ramsey/uuid package, and Laravel's built-in Str::uuid() helper — with when to use each.",
        'category' => "PHP & Laravel",
        'body' => <<<MARKDOWN
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
    \$data = random_bytes(16);

    // Set version to 0100 (UUID v4)
    \$data[6] = chr(ord(\$data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10 (variant RFC 4122)
    \$data[8] = chr(ord(\$data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(\$data), 4));
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

\$uuid4 = Uuid::uuid4();
echo \$uuid4->toString();

// Other versions are available too:
\$uuid1 = Uuid::uuid1();   // time-based
\$uuid5 = Uuid::uuid5(Uuid::NAMESPACE_URL, 'https://ohene.dev'); // name-based, deterministic
```

`uuid5` is worth knowing about specifically — it generates the *same* UUID every time for the same namespace + name input, which is useful when you want a stable, unique ID derived from something like a URL or email address.

## Option 3 — Laravel's Built-In Helper

If you're already in a Laravel app, you don't need a package at all — Laravel ships with UUID generation via its `Str` helper (which itself wraps `ramsey/uuid` under the hood):

```php
use Illuminate\Support\Str;

\$uuid = Str::uuid();
echo \$uuid->toString();
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
\$table->uuid('id')->primary();
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
MARKDOWN
    ]
];

foreach ($blogs as $blog) {
    echo "Processing '{$blog['title']}'...\n";
    
    // Create or get category
    $category = Category::firstOrCreate(
        ['name' => $blog['category']],
        ['slug' => Str::slug($blog['category'])]
    );
    
    // Estimate read time (avg 200 words per minute)
    $wordCount = str_word_count(strip_tags($blog['body']));
    $readTime = max(1, ceil($wordCount / 200));

    // Upsert the post
    $post = Post::updateOrCreate(
        ['slug' => $blog['slug']],
        [
            'title' => $blog['title'],
            'category_id' => $category->id,
            'excerpt' => $blog['meta_description'], // Using meta description as a fallback excerpt
            'body' => $blog['body'],
            'read_time' => $readTime,
            'status' => 'published',
            'published_at' => now(),
            'meta_title' => $blog['title'],
            'meta_description' => $blog['meta_description'],
        ]
    );

    echo "Successfully imported!\n\n";
}

echo "All blogs imported!\n";
