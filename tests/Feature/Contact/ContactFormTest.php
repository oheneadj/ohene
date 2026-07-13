<?php

declare(strict_types=1);

use App\Events\LeadSubmitted;
use App\Livewire\ContactForm;
use App\Mail\LeadAdminNotification;
use App\Mail\LeadAutoReply;
use App\Models\Lead;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;

beforeEach(function () {
    RateLimiter::clear('contact-form:127.0.0.1');
});

it('creates a lead and fires the LeadSubmitted event on valid submission', function () {
    Event::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'Ama Client')
        ->set('email', 'ama@example.com')
        ->set('message', 'I need a Laravel app built for my business.')
        ->set('project_type', 'web_app')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    $lead = Lead::sole();
    expect($lead->name)->toBe('Ama Client')
        ->and($lead->email)->toBe('ama@example.com')
        ->and($lead->project_type->value)->toBe('web_app');

    Event::assertDispatched(LeadSubmitted::class);
});

it('sends the admin notification and auto-reply emails', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'Kofi Client')
        ->set('email', 'kofi@example.com')
        ->set('message', 'Please help me build an API integration.')
        ->call('submit')
        ->assertHasNoErrors();

    Mail::assertQueued(LeadAdminNotification::class);
    Mail::assertQueued(LeadAutoReply::class, fn (LeadAutoReply $mail) => $mail->hasTo('kofi@example.com'));
});

it('validates required fields', function () {
    Livewire::test(ContactForm::class)
        ->set('message', 'too short')
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'message']);

    expect(Lead::count())->toBe(0);
});

it('silently drops honeypot submissions without creating a lead', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'Spam Bot')
        ->set('email', 'bot@example.com')
        ->set('message', 'buy cheap things now')
        ->set('website', 'http://spam.example')
        ->call('submit')
        ->assertSet('submitted', true);

    expect(Lead::count())->toBe(0);
    Mail::assertNothingQueued();
});

it('rate limits repeated submissions from the same visitor', function () {
    Mail::fake();

    foreach (range(1, 5) as $i) {
        Livewire::test(ContactForm::class)
            ->set('name', "Client {$i}")
            ->set('email', "client{$i}@example.com")
            ->set('message', 'A genuine project inquiry message.')
            ->call('submit')
            ->assertHasNoErrors();
    }

    Livewire::test(ContactForm::class)
        ->set('name', 'One Too Many')
        ->set('email', 'over@example.com')
        ->set('message', 'This one should be throttled out.')
        ->call('submit')
        ->assertHasErrors('message');

    expect(Lead::count())->toBe(5);
});

it('captures utm parameters onto the lead', function () {
    Livewire::test(ContactForm::class)
        ->set('utm_source', 'linkedin')
        ->set('utm_medium', 'social')
        ->set('name', 'Tracked Lead')
        ->set('email', 'tracked@example.com')
        ->set('message', 'Found you through a LinkedIn post.')
        ->call('submit')
        ->assertHasNoErrors();

    $lead = Lead::sole();
    expect($lead->utm_source)->toBe('linkedin')
        ->and($lead->utm_medium)->toBe('social');
});
