<?php

declare(strict_types=1);

namespace App\Filament\Resources\Testimonials\Pages;

use App\Filament\Resources\Testimonials\TestimonialResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Admin create page for a testimonial record.
 */
class CreateTestimonial extends CreateRecord
{
    protected static string $resource = TestimonialResource::class;
}
