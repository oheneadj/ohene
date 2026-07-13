@php
    $provider = config('site.analytics.provider');
@endphp

{{-- Cookieless providers load immediately (no consent needed). GA4 sets cookies,
     so it's exposed as meta tags and only loaded by app.js after the visitor
     accepts the cookie banner (MR3 + consent). Renders nothing in dev. --}}
@if ($provider === 'cloudflare' && config('site.analytics.cloudflare_token'))
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js" data-cf-beacon='{"token": "{{ config('site.analytics.cloudflare_token') }}"}'></script>
@elseif ($provider === 'plausible' && config('site.analytics.plausible_domain'))
    <script defer data-domain="{{ config('site.analytics.plausible_domain') }}" src="https://plausible.io/js/script.tagged-events.js"></script>
@elseif ($provider === 'ga4' && config('site.analytics.ga4_id'))
    <meta name="analytics-provider" content="ga4">
    <meta name="analytics-ga4-id" content="{{ config('site.analytics.ga4_id') }}">
@endif
