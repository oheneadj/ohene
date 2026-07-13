<?php

declare(strict_types=1);

use App\Models\Setting;

it('reads and writes settings by key', function () {
    Setting::set('available_for_projects', '1');

    expect(Setting::get('available_for_projects'))->toBe('1');
});

it('returns the default when a setting is missing', function () {
    expect(Setting::get('missing_key', 'fallback'))->toBe('fallback')
        ->and(Setting::get('missing_key'))->toBeNull();
});

it('updates an existing setting without creating a duplicate', function () {
    Setting::set('available_for_projects', '1');
    Setting::set('available_for_projects', '0');

    expect(Setting::get('available_for_projects'))->toBe('0')
        ->and(Setting::where('key', 'available_for_projects')->count())->toBe(1);
});
