@props([
    'title' => 'Ohene Adjei Effah — Full-Stack Developer for Hire',
    'description' => 'Hire Ohene Adjei Effah, a full-stack web developer building Laravel, React and WordPress solutions — custom apps, APIs, e-commerce and ongoing site care.',
    'image' => null,
    'type' => 'website',
    'published_time' => null,
    'modified_time' => null,
])

@php
    $ogImage = \App\Helpers\AssetHelper::url($image) ?? asset('og-default.webp');
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('icon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <meta property="og:site_name" content="{{ config('site.name') }}">
    <meta property="og:type" content="{{ $type }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage }}">

    @if($type === 'article')
        @if($published_time) <meta property="article:published_time" content="{{ $published_time }}"> @endif
        @if($modified_time) <meta property="article:modified_time" content="{{ $modified_time }}"> @endif
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    <link rel="alternate" type="application/rss+xml" title="Ohene Adjei Effah — Blog" href="{{ route('rss') }}">

    <x-analytics />

    {{-- Per-page structured data / extra head tags --}}
    {{ $head ?? '' }}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-black antialiased min-h-screen flex flex-col relative overflow-x-hidden">
    <div class="bg-aurora-light" aria-hidden="true"></div>
    
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 bg-black text-white font-mono text-sm px-4 py-2 rounded">Skip to content</a>

    @auth
        <x-admin-bar />
    @endauth

    <x-nav />

    <main id="main" class="flex-grow">
        {{ $slot }}
    </main>

    <x-footer />

    <x-scroll-to-top />
    <x-cookie-consent />
</body>
</html>
