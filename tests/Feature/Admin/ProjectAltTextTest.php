<?php

declare(strict_types=1);

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->create());
});

it('requires cover alt text when a project has a cover image', function () {
    Livewire::test(CreateProject::class)
        ->fillForm([
            'title' => 'Test Project',
            'slug' => 'test-project',
            'tagline' => 'A one-line tagline',
            'challenge' => 'The challenge',
            'build' => 'The build',
            'impact' => 'The impact',
            'tech_stack' => ['Laravel'],
            'cover_image' => [UploadedFile::fake()->image('cover.jpg', 1200, 675)],
            'cover_image_alt' => null,
            'display_order' => 0,
        ])
        ->call('create')
        ->assertHasFormErrors(['cover_image_alt']);
});

it('allows a project with no cover image and no alt text', function () {
    Livewire::test(CreateProject::class)
        ->fillForm([
            'title' => 'No Cover Project',
            'slug' => 'no-cover-project',
            'tagline' => 'A one-line tagline',
            'challenge' => 'The challenge',
            'build' => 'The build',
            'impact' => 'The impact',
            'tech_stack' => ['Laravel'],
            'display_order' => 0,
        ])
        ->call('create')
        ->assertHasNoFormErrors();
});
