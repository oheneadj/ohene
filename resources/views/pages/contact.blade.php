<x-layouts.app
    title="Contact Ohene Adjei Effah — Full-Stack Web Developer"
    description="Get in touch with Ohene Adjei Effah about a Laravel, React or WordPress project — freelance and full-time work considered.">

    <x-slot:head>
        <x-json-ld :data="[
            [
                '@context' => 'https://schema.org',
                '@type' => 'ContactPage',
                'url' => route('contact'),
                'about' => [
                    '@type' => 'Person',
                    'name' => config('site.name'),
                    'email' => 'mailto:' . config('site.email'),
                    'telephone' => config('site.phone'),
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Contact', 'item' => route('contact')],
                ]
            ]
        ]" />
    </x-slot:head>

    <section class="bg-black text-white relative overflow-hidden py-24 md:py-32 border-b border-white/10">
        <div class="bg-aurora-animated pointer-events-none opacity-40" aria-hidden="true"></div>
        <div class="max-w-6xl mx-auto px-7 relative z-10">
            <p class="font-mono text-xs uppercase tracking-widest text-forest mb-4">&rsaquo; ~/contact</p>
            <h1 class="font-display text-4xl md:text-5xl font-semibold mb-5">Let's build something.</h1>
            <p class="text-slate-300 max-w-xl mb-10 text-lg">Tell me what you're trying to build. I'll get back to you within a day with thoughts on scope, timeline and next steps.</p>
            <div class="flex flex-wrap gap-4 mt-6">
                <a href="mailto:oheneadjei.dev@gmail.com?subject=Project%20inquiry" class="flex items-center gap-2.5 bg-white/5 border border-white/10 backdrop-blur-md rounded-full px-5 py-3 text-sm font-medium hover:bg-white/10 hover:border-white/20 hover:-translate-y-0.5 transition-premium text-slate-200 hover:text-white group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    oheneadjei.dev@gmail.com
                </a>
                <a href="tel:+233206657172" class="flex items-center gap-2.5 bg-white/5 border border-white/10 backdrop-blur-md rounded-full px-5 py-3 text-sm font-medium hover:bg-white/10 hover:border-white/20 hover:-translate-y-0.5 transition-premium text-slate-200 hover:text-white group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    +233 020 665 7172
                </a>
                <a href="https://linkedin.com/in/oheneadj" target="_blank" rel="noopener" class="flex items-center gap-2.5 bg-white/5 border border-white/10 backdrop-blur-md rounded-full px-5 py-3 text-sm font-medium hover:bg-white/10 hover:border-white/20 hover:-translate-y-0.5 transition-premium text-slate-200 hover:text-white group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"></path></svg>
                    LinkedIn
                </a>
                <a href="https://github.com/oheneadj" target="_blank" rel="noopener" class="flex items-center gap-2.5 bg-white/5 border border-white/10 backdrop-blur-md rounded-full px-5 py-3 text-sm font-medium hover:bg-white/10 hover:border-white/20 hover:-translate-y-0.5 transition-premium text-slate-200 hover:text-white group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                    GitHub
                </a>
                <a href="{{ asset('Ohene_Adjei_Effah_Resume.pdf') }}" download data-track="resume_download" class="flex items-center gap-2.5 bg-white/5 border border-white/10 backdrop-blur-md rounded-full px-5 py-3 text-sm font-medium hover:bg-white/10 hover:border-white/20 hover:-translate-y-0.5 transition-premium text-slate-200 hover:text-white group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Resume
                </a>
            </div>
        </div>
    </section>



    <section class="max-w-6xl mx-auto px-7 py-16">
        <div class="max-w-3xl">
            <x-eyebrow>~/start-a-project</x-eyebrow>
            <h2 class="font-display text-2xl font-semibold mb-8">Tell me about it</h2>
            <livewire:contact-form />
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-7 pb-16">
        <div class="max-w-5xl">
            <x-eyebrow>what happens next</x-eyebrow>
            <h2 class="font-display text-2xl font-semibold mb-8">Three steps, no pressure</h2>
            <div class="grid sm:grid-cols-3 gap-5">
                <x-process-step number="01" title="You reach out">Send a quick note about what you need — no brief required.</x-process-step>
                <x-process-step number="02" title="We talk it through">A short call or email exchange to understand scope and timeline.</x-process-step>
                <x-process-step number="03" title="I send a plan">A clear proposal with cost and timeline before anything is committed.</x-process-step>
            </div>
        </div>
    </section>
</x-layouts.app>
