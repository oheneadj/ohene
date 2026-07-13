<?php

declare(strict_types=1);

it('sends baseline security headers on web responses', function () {
    $response = $this->get(route('home'));

    $response->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
        ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
});

it('adds HSTS only over https', function () {
    $this->get(route('home'))->assertHeaderMissing('Strict-Transport-Security');

    $this->get('https://localhost'.route('home', absolute: false))
        ->assertHeader('Strict-Transport-Security');
});
