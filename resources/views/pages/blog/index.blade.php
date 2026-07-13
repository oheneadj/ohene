<x-layouts.app
    title="Blog — Ohene Adjei Effah"
    description="Practical write-ups on Laravel, WordPress performance, and shipping secure, scalable web applications — pulled from real client work.">

    <x-slot:head>
        <x-json-ld :data="[
            [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Blog — Ohene Adjei Effah',
                'description' => 'Practical write-ups on Laravel, WordPress performance, and shipping secure, scalable web applications — pulled from real client work.',
                'url' => route('blog.index'),
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => route('blog.index')],
                ]
            ]
        ]" />
    </x-slot:head>

    <section class="bg-black text-white relative overflow-hidden py-24 md:py-32 border-b border-white/10">
        <div class="bg-aurora-animated pointer-events-none opacity-40" aria-hidden="true"></div>
        <div class="max-w-6xl mx-auto px-7 relative z-10">
            <p class="font-mono text-xs uppercase tracking-widest text-forest mb-4">&rsaquo; ~/blog</p>
            <h1 class="font-display text-4xl md:text-5xl font-semibold mb-5">Notes &amp; insights</h1>
            <p class="text-slate-300 max-w-xl text-lg">Practical write-ups on Laravel, WordPress performance, and shipping secure, scalable web applications — pulled from real client work.</p>
        </div>
    </section>



    <section class="max-w-6xl mx-auto px-7 py-16">
        @if ($posts->isEmpty())
            <p class="text-slate-500">No posts published yet — check back soon.</p>
        @else
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    <x-blog-card :post="$post" :accent="['gold', 'forest'][$loop->index % 2]" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif
    </section>
</x-layouts.app>
