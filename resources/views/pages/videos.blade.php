<x-layouts.app title="Dev Videos — Ohene Adjei Effah"
    description="Short development videos and walkthroughs from full-stack developer Ohene Adjei Effah.">

    <x-slot:head>
        @php
            $videoItems = [];
            foreach ($videos as $i => $video) {
                $videoItems[] = [
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'item' => [
                        '@type' => 'VideoObject',
                        'name' => $video->title,
                        'description' => $video->description,
                        'thumbnailUrl' => $video->thumbnailUrl(),
                        'uploadDate' => $video->published_at?->toAtomString(),
                        'embedUrl' => 'https://www.youtube.com/embed/' . $video->youtube_video_id,
                    ]
                ];
            }
        @endphp
        <x-json-ld :data="array_filter([
        [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Videos', 'item' => route('videos')],
            ]
        ],
        count($videoItems) > 0 ? [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'itemListElement' => $videoItems
        ] : null
    ])" />
    </x-slot:head>

    <section class="bg-black text-white relative overflow-hidden min-h-[40vh] flex flex-col justify-center py-20 border-b border-white/10">
        <div class="bg-aurora-animated pointer-events-none opacity-30" aria-hidden="true"></div>
        <div class="max-w-6xl mx-auto px-7 relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-10 w-full">
            <div class="max-w-2xl">
                <p class="font-mono text-xs uppercase tracking-widest text-forest mb-4">&rsaquo; ~/videos</p>
                <h1 class="font-display text-4xl md:text-5xl font-semibold mb-5">Dev videos</h1>
                <p class="text-slate-300 text-lg leading-relaxed">Short walkthroughs, coding sessions, and build notes.
                    All content is hosted directly on YouTube for the best playback experience.</p>
            </div>

            {{-- Modern YouTube Channel Widget --}}
            <div
                class="flex-shrink-0 bg-white/5 border border-white/10 p-5 rounded-[2rem] backdrop-blur-md flex items-center gap-5 hover:bg-white/10 transition-colors group">
                <div
                    class="w-14 h-14 rounded-full bg-[#FF0000] flex items-center justify-center flex-shrink-0 shadow-[0_0_20px_rgba(255,0,0,0.3)] group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <h3 class="font-display font-semibold text-white text-lg">Ohene Adjei </h3>
                    <p class="text-sm text-slate-400 mb-3">Tech & Web Development &bull; {{ $videos->count() }} Videos
                    </p>
                    <a href="{{ config('site.social.youtube') }}" target="_blank" rel="noopener"
                        class="inline-flex items-center justify-center gap-2 bg-white text-black hover:bg-slate-200 text-sm font-semibold px-5 py-2 rounded-full transition-colors w-full sm:w-auto shadow-sm">
                        <svg class="w-4 h-4 text-[#FF0000]" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                        </svg>
                        <span>Subscribe on YouTube</span>
                    </a>
                </div>
            </div>
        </div>
    </section>



    <section class="max-w-6xl mx-auto px-7 py-16">
        @if ($videos->isEmpty())
            <div class="grid md:grid-cols-3 gap-5">
                @for ($i = 0; $i < 3; $i++)
                    <div
                        class="border-2 border-dashed border-black/15 rounded-xl h-40 flex items-center justify-center text-slate-400 font-mono text-xs">
                        Coming soon</div>
                @endfor
            </div>
        @else
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($videos as $video)
                    <x-video-card :video="$video" />
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.app>