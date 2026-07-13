<?php

declare(strict_types=1);

use App\Enums\LeadStatus;
use App\Filament\Resources\Leads\LeadResource;
use App\Models\Lead;
use App\Models\Post;
use App\Models\User;

it('redirects guests away from the admin panel', function () {
    $this->get('/admin')->assertRedirect();
});

it('lets an authenticated admin reach the panel', function () {
    $this->actingAs(User::factory()->create())
        ->get('/admin')
        ->assertSuccessful();
});

it('allows the admin to manage content', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    expect($user->can('viewAny', Post::class))->toBeTrue()
        ->and($user->can('create', Post::class))->toBeTrue()
        ->and($user->can('update', $post))->toBeTrue()
        ->and($user->can('delete', $post))->toBeTrue();
});

it('renders every resource listing without error', function (string $slug) {
    $this->actingAs(User::factory()->create())
        ->get("/admin/{$slug}")
        ->assertSuccessful();
})->with(['projects', 'posts', 'categories', 'testimonials', 'videos', 'leads']);

it('keeps leads read-only: no create or delete', function () {
    $user = User::factory()->create();
    $lead = Lead::factory()->create();

    expect($user->can('viewAny', Lead::class))->toBeTrue()
        ->and($user->can('update', $lead))->toBeTrue()
        ->and($user->can('create', Lead::class))->toBeFalse()
        ->and($user->can('delete', $lead))->toBeFalse();
});

it('badges the lead nav with the count of new leads', function () {
    Lead::factory()->count(3)->create(['status' => LeadStatus::New]);
    Lead::factory()->create(['status' => LeadStatus::Won]);

    expect(LeadResource::getNavigationBadge())->toBe('3');
});

it('renders the dashboard with the stats widget', function () {
    Lead::factory()->create(['status' => LeadStatus::New]);

    $this->actingAs(User::factory()->create())
        ->get('/admin')
        ->assertSuccessful()
        ->assertSee('New leads');
});
