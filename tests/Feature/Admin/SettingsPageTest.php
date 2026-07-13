<?php

declare(strict_types=1);

use App\Filament\Pages\ManageSiteSettings;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->create());
});

it('loads the current availability setting into the form', function () {
    Setting::set('available_for_projects', '1');

    Livewire::test(ManageSiteSettings::class)
        ->assertSet('data.available_for_projects', true);
});

it('persists the availability toggle when saved', function () {
    Setting::set('available_for_projects', '1');

    Livewire::test(ManageSiteSettings::class)
        ->set('data.available_for_projects', false)
        ->call('save')
        ->assertHasNoErrors();

    expect(Setting::get('available_for_projects'))->toBe('0');
});

it('loads the current about image setting into the form', function () {
    Storage::disk('public')->put('settings/custom.png', 'dummy');
    Setting::set('about_image', 'settings/custom.png');

    $test = Livewire::test(ManageSiteSettings::class);
    $aboutImage = $test->get('data.about_image');

    expect($aboutImage)->toBeArray();
    expect(array_values($aboutImage))->toContain('settings/custom.png');
});

it('persists the about image setting when saved', function () {
    Setting::set('about_image', 'settings/old.png');

    Livewire::test(ManageSiteSettings::class)
        ->set('data.about_image', ['settings/new.png'])
        ->call('save')
        ->assertHasNoErrors();

    expect(Setting::get('about_image'))->toBe('settings/new.png');
});
