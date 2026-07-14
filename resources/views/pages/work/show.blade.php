@php
    $liveHost = $project->live_url ? preg_replace('#^https?://(www\.)?#', '', rtrim($project->live_url, '/')) : null;
@endphp

<x-layouts.app :title="$project->meta_title ?? $project->title . ' — Case Study | Ohene Adjei Effah'"
    :description="$project->meta_description ?? $project->tagline"
    :image="$project->ogImage()">

    <x-slot:head>
        <x-json-ld :data="[
            [
                '@context' => 'https://schema.org',
                '@type' => 'CreativeWork',
                'name' => $project->title,
                'description' => $project->tagline,
                'image' => \App\Helpers\AssetHelper::url($project->ogImage()),
                'url' => route('work.show', $project),
                'creator' => ['@type' => 'Person', 'name' => config('site.name')],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Work', 'item' => route('work.index')],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $project->title, 'item' => route('work.show', $project)],
                ]
            ]
        ]" />
    </x-slot:head>

    <section
        class="bg-black text-white relative overflow-hidden pt-24 pb-32 md:pt-32 md:pb-48 border-b border-white/10">
        <div class="bg-aurora-animated pointer-events-none opacity-40" aria-hidden="true"></div>
        <div class="max-w-6xl mx-auto px-7 relative z-10">
            <p class="font-mono text-xs text-slate-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a> /
                <a href="{{ route('work.index') }}" class="hover:text-white transition-colors">Work</a> /
                <span class="text-white">{{ $project->title }}</span>
            </p>
            <p class="font-mono text-xs uppercase tracking-widest text-forest mb-4">&rsaquo; ~/work/{{ $project->slug }}
            </p>
            <h1 class="font-display text-4xl md:text-5xl font-semibold mb-6 leading-tight max-w-4xl">{{ $project->title }}
            </h1>
            <p class="text-slate-300 text-lg md:text-xl max-w-2xl">{{ $project->tagline }}</p>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-7 -mt-16 md:-mt-32 relative z-20 pb-14">
        {{-- Browser mock: real cover image if set, otherwise a styled skeleton. --}}
        <div
            class="reveal rounded-[2rem] overflow-hidden border border-black/5 shadow-[0_8px_30px_rgba(0,0,0,0.08)] bg-white mb-12">
            <div class="flex items-center gap-2 px-6 py-4 bg-[#F4F5F2] border-b border-black/5">
                <span class="w-3 h-3 rounded-full bg-black/15"></span>
                <span class="w-3 h-3 rounded-full bg-black/15"></span>
                <span class="w-3 h-3 rounded-full bg-black/15"></span>
                @if ($liveHost)
                    <span
                        class="ml-3 font-mono text-[11px] text-slate-500 bg-white px-3 py-1 rounded-md border border-black/5 shadow-sm">{{ $liveHost }}</span>
                @endif
            </div>
            @if ($project->cover_image)
                <img src="{{ \App\Helpers\AssetHelper::url($project->cover_image) }}"
                    alt="{{ $project->cover_image_alt ?? $project->title }}" class="w-full">
            @else
                <div class="p-6 bg-white flex flex-col gap-3">
                    <div class="h-3.5 w-40 rounded bg-black/80"></div>
                    <div class="h-14 rounded-lg bg-black/15"></div>
                    <div class="grid grid-cols-3 gap-2.5">
                        <span class="h-12 rounded-lg bg-black/10"></span>
                        <span class="h-12 rounded-lg bg-black/10"></span>
                        <span class="h-12 rounded-lg bg-black/10"></span>
                    </div>
                </div>
            @endif
        </div>{{-- /browser mock --}}

        <div class="space-y-14 mb-16 max-w-4xl">
            <div class="reveal">
                <b class="block font-mono text-xs uppercase tracking-widest text-slate-400 mb-4">Challenge</b>
                <p class="text-lg text-slate-700 leading-relaxed">{{ $project->challenge }}</p>
            </div>
            <div class="reveal">
                <b class="block font-mono text-xs uppercase tracking-widest text-slate-400 mb-4">Build</b>
                <p class="text-lg text-slate-700 leading-relaxed">{{ $project->build }}</p>
            </div>
            <div class="reveal">
                <b class="block font-mono text-xs uppercase tracking-widest text-slate-400 mb-4">Impact</b>
                <p class="text-lg text-slate-700 leading-relaxed">{{ $project->impact }}</p>
            </div>
        </div>

        <div class="reveal flex flex-wrap gap-2 mb-10">
            @foreach ($project->tech_stack as $tech)
                <span
                    class="font-mono text-xs bg-white border border-black/5 shadow-sm px-4 py-2 rounded-full text-slate-600">{{ $tech }}</span>
            @endforeach
        </div>

        @if (!empty($project->gallery))
            <div class="reveal mb-16">
                <b class="block font-mono text-xs uppercase tracking-widest text-slate-400 mb-6">Gallery</b>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($project->gallery as $i => $image)
                        <button
                            type="button"
                            data-gallery-index="{{ $i }}"
                            data-gallery-trigger="{{ \App\Helpers\AssetHelper::url($image) }}"
                            class="relative aspect-video rounded-xl overflow-hidden bg-slate-50 border border-black/5 hover:border-black/20 hover:shadow-md group transition-all duration-300">
                            <img src="{{ \App\Helpers\AssetHelper::url($image) }}"
                                 alt="Gallery thumbnail {{ $i + 1 }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Vanilla JS Lightbox --}}
            <div id="gallery-lightbox" aria-modal="true" role="dialog" aria-label="Image viewer"
                 style="display:none; position:fixed; inset:0; background:rgba(255,255,255,0.85); backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px); z-index:100; flex-direction:column; align-items:center; justify-content:center;">
                
                {{-- Controls Bar --}}
                <div style="position:absolute; top:0; left:0; right:0; display:flex; justify-content:space-between; align-items:center; padding:1.5rem 2rem; z-index:110;">
                    <span id="gallery-lightbox-counter" class="font-mono text-sm font-semibold text-slate-800 bg-white/80 px-4 py-1.5 rounded-full shadow-sm border border-black/5"></span>
                    <button id="gallery-lightbox-close" type="button" class="w-10 h-10 rounded-full bg-white/80 border border-black/5 shadow-sm flex items-center justify-center text-slate-800 hover:bg-white hover:scale-105 transition-all" aria-label="Close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- Left Arrow --}}
                <button id="gallery-lightbox-prev" type="button" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/80 border border-black/5 shadow-sm flex items-center justify-center text-slate-800 hover:bg-white hover:scale-105 transition-all z-[110]" aria-label="Previous">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                {{-- Right Arrow --}}
                <button id="gallery-lightbox-next" type="button" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/80 border border-black/5 shadow-sm flex items-center justify-center text-slate-800 hover:bg-white hover:scale-105 transition-all z-[110]" aria-label="Next">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <div id="gallery-lightbox-inner" style="max-width:72rem; max-height:85vh; padding-top:3.5rem; display:flex; align-items:center; justify-content:center;">
                    <img id="gallery-lightbox-img" src="" alt="Expanded gallery view"
                         style="max-width:100%; max-height:85vh; object-fit:contain; border-radius:0.75rem; box-shadow:0 4px 24px rgba(0,0,0,0.12); transition:opacity 0.2s ease; opacity:0;">
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const triggers = Array.from(document.querySelectorAll('[data-gallery-trigger]'));
                    const lightbox = document.getElementById('gallery-lightbox');
                    const img = document.getElementById('gallery-lightbox-img');
                    const closeBtn = document.getElementById('gallery-lightbox-close');
                    const prevBtn = document.getElementById('gallery-lightbox-prev');
                    const nextBtn = document.getElementById('gallery-lightbox-next');
                    const counter = document.getElementById('gallery-lightbox-counter');
                    
                    if (!triggers.length || !lightbox || !img) return;
                    
                    let currentIndex = 0;
                    const images = triggers.map(t => t.getAttribute('data-gallery-trigger'));
                    
                    function updateImage(index) {
                        img.style.opacity = '0';
                        setTimeout(() => {
                            img.src = images[index];
                            counter.textContent = `${index + 1} / ${images.length}`;
                            img.onload = () => { img.style.opacity = '1'; };
                        }, 200);
                    }

                    function openGallery(index) {
                        currentIndex = index;
                        updateImage(currentIndex);
                        lightbox.style.display = 'flex';
                        document.body.style.overflow = 'hidden';
                    }
                    
                    function closeGallery() {
                        lightbox.style.display = 'none';
                        document.body.style.overflow = '';
                        img.src = '';
                    }

                    function prev() {
                        currentIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
                        updateImage(currentIndex);
                    }

                    function next() {
                        currentIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
                        updateImage(currentIndex);
                    }

                    triggers.forEach(t => {
                        t.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            const idx = parseInt(t.getAttribute('data-gallery-index'), 10);
                            openGallery(idx);
                        });
                    });

                    closeBtn.addEventListener('click', closeGallery);
                    prevBtn.addEventListener('click', prev);
                    nextBtn.addEventListener('click', next);

                    lightbox.addEventListener('click', (e) => {
                        if (e.target !== img && e.target !== prevBtn && e.target !== nextBtn && !prevBtn.contains(e.target) && !nextBtn.contains(e.target)) {
                            closeGallery();
                        }
                    });

                    document.addEventListener('keydown', (e) => {
                        if (lightbox.style.display === 'flex') {
                            if (e.key === 'Escape') closeGallery();
                            if (e.key === 'ArrowLeft') prev();
                            if (e.key === 'ArrowRight') next();
                        }
                    });
                });
            </script>
        @endif

        @if ($project->live_url || $project->repo_url)
            <div class="reveal flex flex-wrap gap-4 mb-16 border-t border-black/5 pt-10">
                @if ($project->live_url)
                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-2 bg-black text-white font-semibold rounded-full px-8 py-3.5 border border-black hover:bg-transparent hover:text-black shadow-md hover:-translate-y-0.5 transition-premium">
                        Visit the site &rarr;
                    </a>
                @endif
                @if ($project->repo_url)
                    <a href="{{ $project->repo_url }}" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-2 bg-white border border-black/10 text-black font-semibold rounded-full px-8 py-3.5 hover:bg-slate-50 transition shadow-sm hover:-translate-y-0.5 transition-premium">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                clip-rule="evenodd"></path>
                        </svg>
                        View on GitHub
                    </a>
                @endif
            </div>
        @endif

        @if ($testimonials->isNotEmpty())
            <div class="grid gap-6 mb-14">
                @foreach ($testimonials as $testimonial)
                    <x-testimonial-card :testimonial="$testimonial" />
                @endforeach
            </div>
        @endif

        <div class="flex items-center justify-between border-t border-black/10 pt-8">
            @if ($previous)
                <a href="{{ route('work.show', $previous) }}"
                    class="text-sm font-semibold text-slate-500 hover:text-black">&larr; {{ $previous->title }}</a>
            @else
                <a href="{{ route('work.index') }}" class="text-sm font-semibold text-slate-500 hover:text-black">&larr; All
                    work</a>
            @endif

            @if ($next)
                <a href="{{ route('work.show', $next) }}" class="text-sm font-semibold text-black hover:underline">Next:
                    {{ $next->title }} &rarr;</a>
            @else
                <a href="{{ route('work.index') }}" class="text-sm font-semibold text-black hover:underline">Back to work
                    &rarr;</a>
            @endif
        </div>
    </div>
</x-layouts.app>