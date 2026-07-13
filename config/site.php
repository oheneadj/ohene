<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Identity
    |--------------------------------------------------------------------------
    |
    | Canonical facts about the site owner, used for JSON-LD structured data
    | (FR14) and anywhere else the person's public details are needed. Kept in
    | config so they're defined once rather than scattered across views.
    |
    */

    'name' => 'Ohene Adjei Effah',
    'job_title' => 'Full-Stack Web Developer',
    'email' => 'oheneadjei.dev@gmail.com',
    'phone' => '+233206657172',
    'locality' => 'Accra',
    'region' => 'Greater Accra Region',
    'country' => 'Ghana',

    'stats' => [
        'career_start_year' => 2018,
        'end_users' => '10,000+',
        'wp_builds' => '35+',
        'traffic_lift' => '40%',
    ],

    'same_as' => [
        'https://linkedin.com/in/oheneadj',
        'https://github.com/oheneadj',
        'https://twitter.com/oheneadj',
        'https://youtube.com/@oheneadjei',
    ],

    'knows_about' => [
        'PHP', 'Laravel', 'JavaScript', 'React', 'Node.js', 'MySQL', 'WordPress', 'AWS',
    ],

    /*
    |--------------------------------------------------------------------------
    | Analytics
    |--------------------------------------------------------------------------
    |
    | Provider-agnostic (MR3). Leave the provider unset in local/dev and pick one
    | at launch — all three below are free and hosted (no self-hosting):
    |   - "cloudflare": cookieless, no consent banner (needs the domain on
    |     Cloudflare's free plan). Recommended for conversion + privacy.
    |   - "ga4": free, but sets cookies, so it needs a consent banner.
    |   - "plausible": if a Plausible account is ever used.
    |
    | Event tracking (contact submit, resume download, outbound clicks) works the
    | same regardless of provider via the track() helper in resources/js/app.js.
    |
    */

    'analytics' => [
        'provider' => env('ANALYTICS_PROVIDER'),
        'ga4_id' => env('ANALYTICS_GA4_ID'),
        'plausible_domain' => env('ANALYTICS_PLAUSIBLE_DOMAIN'),
        'cloudflare_token' => env('ANALYTICS_CLOUDFLARE_TOKEN'),
    ],

];
