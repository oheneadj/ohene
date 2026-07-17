<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Actions\CreateLeadAction;
use App\Enums\BudgetRange;
use App\Enums\ProjectType;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

/**
 * The public contact form. UI + orchestration only — persistence and the
 * follow-up emails live in CreateLeadAction (CLAUDE.md Section 9). Includes a
 * honeypot and rate limiting for low-friction spam protection (requirements 5.5).
 */
class ContactForm extends Component
{
    public string $name = '';

    public string $email = '';

    public string $message = '';

    public ?string $project_type = null;

    public ?string $budget_range = null;

    /** Honeypot — real people leave this empty; bots tend to fill it. */
    public string $website = '';

    // Lead source, captured from the incoming request (requirements MR2).
    public ?string $utm_source = null;

    public ?string $utm_medium = null;

    public ?string $utm_campaign = null;

    public ?string $referrer = null;

    public bool $submitted = false;

    public ?string $turnstileToken = null;

    /**
     * Capture UTM parameters and referrer when the form first loads.
     */
    public function mount(): void
    {
        $this->utm_source = request()->query('utm_source');
        $this->utm_medium = request()->query('utm_medium');
        $this->utm_campaign = request()->query('utm_campaign');
        $this->referrer = request()->headers->get('referer');
    }

    /**
     * Validation rules for the whole form (kept in one place for clarity).
     *
     * @return array<string, array<int, mixed>>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'project_type' => ['nullable', new Enum(ProjectType::class)],
            'budget_range' => ['nullable', new Enum(BudgetRange::class)],
            'turnstileToken' => ['required', 'string'],
        ];
    }

    /**
     * Custom error messages.
     *
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'turnstileToken.required' => 'Please complete the security check.',
        ];
    }

    /**
     * Validate, guard against spam, and create the lead.
     */
    public function submit(CreateLeadAction $createLead): void
    {
        // Silently drop honeypot hits — don't tell a bot it failed.
        if ($this->website !== '') {
            $this->reset(['name', 'email', 'message', 'project_type', 'budget_range', 'website', 'turnstileToken']);
            $this->submitted = true;

            return;
        }

        if (RateLimiter::tooManyAttempts($this->throttleKey(), maxAttempts: 2)) {
            $seconds = RateLimiter::availableIn($this->throttleKey());
            $this->addError('message', 'Too many submissions. Please try again in '.ceil($seconds / 60).' minutes.');

            return;
        }

        $validated = $this->validate();

        // Verify Turnstile token via Cloudflare
        $response = \Illuminate\Support\Facades\Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => config('services.turnstile.secret'),
            'response' => $this->turnstileToken,
            'remoteip' => request()->ip(),
        ]);

        // Log the third-party API call (CLAUDE.md Section 21)
        \App\Models\ApiCallLog::create([
            'service' => 'cloudflare_turnstile',
            'endpoint' => 'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            'request_payload' => [
                'secret' => config('services.turnstile.secret'), // Encrypted by model cast
                'response' => $this->turnstileToken,
                'remoteip' => request()->ip(),
            ],
            'response_payload' => $response->json(), // Encrypted by model cast
            'status_code' => $response->status(),
            'ip_address' => request()->ip(),
        ]);

        if (! $response->successful() || ! ($response->json('success') ?? false)) {
            $this->addError('turnstileToken', 'Security check failed. Please refresh the page and try again.');
            return;
        }

        RateLimiter::hit($this->throttleKey(), 3600); // 1 hour decay

        // Remove turnstile token before passing to action
        unset($validated['turnstileToken']);

        $createLead->execute([
            ...$validated,
            'utm_source' => $this->utm_source,
            'utm_medium' => $this->utm_medium,
            'utm_campaign' => $this->utm_campaign,
            'referrer' => $this->referrer,
        ]);

        $this->reset(['name', 'email', 'message', 'project_type', 'budget_range', 'turnstileToken']);
        $this->submitted = true;

        // Let the frontend forward a conversion event to analytics (MR3).
        $this->dispatch('lead-submitted');
    }

    /**
     * Per-visitor throttle key for the contact form.
     */
    protected function throttleKey(): string
    {
        return 'contact-form:'.request()->ip();
    }

    /**
     * Render the form, exposing the enum options to the view.
     */
    public function render(): View
    {
        return view('livewire.contact-form', [
            'projectTypes' => ProjectType::cases(),
            'budgetRanges' => BudgetRange::cases(),
        ]);
    }
}
