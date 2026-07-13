<x-layouts.app title="Page not found — Ohene Adjei Effah" description="The page you were looking for could not be found.">
    <section class="max-w-3xl mx-auto px-7 py-28 text-center">
        <p class="font-mono text-sm text-gray-500 mb-3">&rsaquo; 404 — not found</p>
        <h1 class="font-display text-4xl md:text-5xl font-semibold mb-4">This page took a wrong turn.</h1>
        <p class="text-slate-600 max-w-md mx-auto mb-8">The page you were after doesn't exist or has moved. Here's the way back.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-black text-white border border-black font-semibold rounded-full px-6 py-3 hover:bg-transparent hover:text-black transition-premium">Home</a>
            <a href="{{ route('work.index') }}" class="inline-flex items-center gap-2 border border-black rounded-full px-6 py-3 font-semibold hover:bg-black hover:text-white transition">Work</a>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 border border-black rounded-full px-6 py-3 font-semibold hover:bg-black hover:text-white transition">Blog</a>
        </div>
    </section>
</x-layouts.app>
