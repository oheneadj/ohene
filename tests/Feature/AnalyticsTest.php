<?php

declare(strict_types=1);

it('renders no analytics snippet when no provider is configured', function () {
    config()->set('site.analytics.provider', null);

    $this->get(route('home'))
        ->assertDontSee('googletagmanager.com', false)
        ->assertDontSee('cloudflareinsights.com', false);
});

it('exposes GA4 via meta tags + consent banner and does not load it server-side', function () {
    config()->set('site.analytics.provider', 'ga4');
    config()->set('site.analytics.ga4_id', 'G-TEST123');

    $this->get(route('home'))
        ->assertSee('name="analytics-ga4-id"', false)
        ->assertSee('G-TEST123', false)
        ->assertSee('id="cookie-consent"', false)
        // GA4 must not load until the visitor accepts (no cookies before consent).
        ->assertDontSee('googletagmanager.com', false);
});

it('shows no consent banner for cookieless providers', function () {
    config()->set('site.analytics.provider', 'cloudflare');
    config()->set('site.analytics.cloudflare_token', 'cf-token-abc');

    $this->get(route('home'))->assertDontSee('id="cookie-consent"', false);
});

it('renders the cookieless Cloudflare snippet when configured', function () {
    config()->set('site.analytics.provider', 'cloudflare');
    config()->set('site.analytics.cloudflare_token', 'cf-token-abc');

    $this->get(route('home'))
        ->assertSee('cloudflareinsights.com', false)
        ->assertSee('cf-token-abc', false);
});
