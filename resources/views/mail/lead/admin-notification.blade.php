<x-mail::message>
# New project inquiry

**{{ $lead->name }}** just submitted the contact form.

- **Email:** {{ $lead->email }}
- **Project type:** {{ $lead->project_type?->label() ?? '—' }}
- **Budget:** {{ $lead->budget_range?->label() ?? '—' }}
@if ($lead->utm_source)
- **Source:** {{ collect([$lead->utm_source, $lead->utm_medium, $lead->utm_campaign])->filter()->join(' / ') }}
@endif

**Message**

{{ $lead->message }}

<x-mail::button :url="config('app.url')">
Open the admin
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
