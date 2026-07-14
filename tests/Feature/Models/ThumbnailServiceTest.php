<?php

declare(strict_types=1);

use App\Models\Project;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('generates a thumbnail when project cover image is saved', function () {
    Storage::fake('public');

    // Create a valid fake image using Laravel's test helpers
    $fakeImage = 'projects/fake-cover.jpg';
    $file = UploadedFile::fake()->image('fake.jpg', 100, 100);
    Storage::disk('public')->put($fakeImage, file_get_contents($file->path()));

    $project = Project::factory()->create([
        'cover_image' => $fakeImage,
    ]);

    expect($project->cover_image_thumbnail)->not->toBeNull()
        ->and(Storage::disk('public')->exists($project->cover_image_thumbnail))->toBeTrue();
});

it('deletes old thumbnail when cover image changes', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('fake.jpg', 100, 100);
    $content = file_get_contents($file->path());

    Storage::disk('public')->put('projects/cover1.jpg', $content);
    Storage::disk('public')->put('projects/cover2.jpg', $content);

    $project = Project::factory()->create([
        'cover_image' => 'projects/cover1.jpg',
    ]);

    $oldThumb = $project->cover_image_thumbnail;
    expect(Storage::disk('public')->exists($oldThumb))->toBeTrue();

    // Change the image
    $project->update([
        'cover_image' => 'projects/cover2.jpg',
    ]);

    $newThumb = $project->cover_image_thumbnail;

    expect($newThumb)->not->toBe($oldThumb)
        ->and(Storage::disk('public')->exists($oldThumb))->toBeFalse()
        ->and(Storage::disk('public')->exists($newThumb))->toBeTrue();
});

it('removes thumbnail when cover image is cleared', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('fake.jpg', 100, 100);
    Storage::disk('public')->put('projects/cover.jpg', file_get_contents($file->path()));

    $project = Project::factory()->create([
        'cover_image' => 'projects/cover.jpg',
    ]);

    $thumb = $project->cover_image_thumbnail;
    expect(Storage::disk('public')->exists($thumb))->toBeTrue();

    $project->update([
        'cover_image' => null,
    ]);

    expect($project->cover_image_thumbnail)->toBeNull()
        ->and(Storage::disk('public')->exists($thumb))->toBeFalse();
});
