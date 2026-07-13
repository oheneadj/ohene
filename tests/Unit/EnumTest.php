<?php

declare(strict_types=1);

use App\Enums\BudgetRange;
use App\Enums\LeadStatus;
use App\Enums\PostStatus;
use App\Enums\ProjectType;
use App\Enums\TestimonialStatus;

it('gives every post status a label and colour', function () {
    foreach (PostStatus::cases() as $status) {
        expect($status->label())->toBeString()->not->toBeEmpty()
            ->and($status->color())->toBeString()->not->toBeEmpty();
    }
});

it('gives every lead status a label and colour', function () {
    foreach (LeadStatus::cases() as $status) {
        expect($status->label())->toBeString()->not->toBeEmpty()
            ->and($status->color())->toBeString()->not->toBeEmpty();
    }
});

it('gives every testimonial status a label and colour', function () {
    foreach (TestimonialStatus::cases() as $status) {
        expect($status->label())->toBeString()->not->toBeEmpty()
            ->and($status->color())->toBeString()->not->toBeEmpty();
    }
});

it('gives every project type and budget range a label', function () {
    foreach (ProjectType::cases() as $type) {
        expect($type->label())->toBeString()->not->toBeEmpty();
    }

    foreach (BudgetRange::cases() as $range) {
        expect($range->label())->toBeString()->not->toBeEmpty();
    }
});

it('stores enums by their string value', function () {
    expect(PostStatus::Published->value)->toBe('published')
        ->and(LeadStatus::New->value)->toBe('new')
        ->and(TestimonialStatus::Approved->value)->toBe('approved');
});
