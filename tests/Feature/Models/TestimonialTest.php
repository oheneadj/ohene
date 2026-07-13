<?php

declare(strict_types=1);

use App\Models\Testimonial;

it('scopes to approved testimonials only', function () {
    Testimonial::factory()->approved()->create();
    Testimonial::factory()->count(2)->create(); // pending by default

    expect(Testimonial::approved()->count())->toBe(1);
});

it('defaults new testimonials to pending', function () {
    $testimonial = Testimonial::factory()->create();

    expect($testimonial->status->value)->toBe('pending');
});
