@php
    $links = [
        ['label' => 'Services', 'href' => route('home') . '#services', 'active' => false],
        ['label' => 'Work', 'href' => route('work.index'), 'active' => request()->routeIs('work.*')],
        ['label' => 'About', 'href' => route('about'), 'active' => request()->routeIs('about')],
        ['label' => 'Blog', 'href' => route('blog.index'), 'active' => request()->routeIs('blog.*')],
        ['label' => 'Videos', 'href' => route('videos'), 'active' => request()->routeIs('videos')],
        ['label' => 'Contact', 'href' => route('contact'), 'active' => request()->routeIs('contact')],
    ];
@endphp

<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-black/10 transition-premium text-black">
    <div class="max-w-6xl mx-auto px-7 py-4 flex items-center justify-between gap-5">
        <a href="{{ route('home') }}" class="font-display font-bold text-xl transition-premium">OA<span class="text-forest">.</span></a>

        <nav class="hidden md:flex gap-7 text-sm font-medium text-slate-600">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" @class(['hover:text-ink transition-premium', 'text-ink font-semibold' => $link['active']])>{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <a href="{{ route('contact') }}" class="hidden md:inline-flex font-mono text-sm bg-black text-white border border-black rounded-full px-4 py-2 hover:bg-transparent hover:text-black transition-premium hover:-translate-y-0.5">Start a project</a>
        <button id="navToggle" class="md:hidden text-2xl leading-none w-12 h-12 flex items-center justify-center -mr-3 rounded-full hover:bg-slate-100 transition-colors" aria-label="Toggle Navigation Menu" aria-expanded="false">☰</button>
    </div>

    <div id="mobileMenu" class="hidden md:hidden flex-col gap-1 bg-white border-b border-black/10 px-7 pb-4">
        @foreach ($links as $link)
            <a href="{{ $link['href'] }}" class="block py-3 border-b border-black/5 last:border-0">{{ $link['label'] }}</a>
        @endforeach
    </div>
</header>
