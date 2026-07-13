<x-layouts.app
    title="Work &amp; Case Studies — Ohene Adjei Effah"
    description="Selected case studies from Ohene Adjei Effah — Laravel, Vue and WordPress projects, from first requirement to measured outcome.">

    <x-slot:head>
        @php
            $items = [];
            foreach ($projects as $i => $item) {
                $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'url' => route('work.show', $item), 'name' => $item->title];
            }
        @endphp
        <x-json-ld :data="[
            [
                '@context' => 'https://schema.org', 
                '@type' => 'ItemList', 
                'itemListElement' => $items
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Work', 'item' => route('work.index')],
                ]
            ]
        ]" />
    </x-slot:head>

    <section class="bg-black text-white relative overflow-hidden py-24 md:py-32 border-b border-white/10">
        <div class="bg-aurora-animated pointer-events-none opacity-40" aria-hidden="true"></div>
        <div class="max-w-6xl mx-auto px-7 relative z-10">
            <p class="font-mono text-xs uppercase tracking-widest text-forest mb-4">&rsaquo; ~/work</p>
            <h1 class="font-display text-4xl md:text-5xl font-semibold mb-5">Selected work</h1>
            <p class="text-slate-300 max-w-xl text-lg">A few projects that show how I approach a problem, from first requirement to what it delivered.</p>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-7 py-10">
        @if ($projects->isEmpty())
            <p class="text-slate-500">Case studies are on the way — check back soon.</p>
        @else
            <div class="flex flex-col gap-10">
                @foreach ($projects as $project)
                    <div>
                        <x-case-study-card :project="$project" :accent="['gold', 'forest', 'rust'][$loop->index % 3]" />
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $projects->links() }}
            </div>
        @endif
    </section>

</x-layouts.app>
