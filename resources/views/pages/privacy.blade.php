<x-layouts.app
    title="Privacy Policy — Ohene Adjei Effah"
    description="How this site handles the information you share — contact form submissions, analytics, and cookies.">

    <x-slot:head>
        <x-json-ld :data="[
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Privacy Policy',
                'url' => route('privacy'),
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Privacy', 'item' => route('privacy')],
                ]
            ]
        ]" />
    </x-slot:head>

    <section class="bg-black text-white relative overflow-hidden py-24 md:py-32 border-b border-white/10">
        <div class="bg-aurora-animated pointer-events-none opacity-40" aria-hidden="true"></div>
        <div class="max-w-6xl mx-auto px-7 relative z-10">
            <p class="font-mono text-xs uppercase tracking-widest text-forest mb-4">&rsaquo; ~/privacy</p>
            <h1 class="font-display text-4xl md:text-5xl font-semibold mb-4">Privacy policy</h1>
            <p class="text-slate-300 max-w-xl text-lg">Plain-language, no surprises. Here's exactly what this site collects, why, and what you can control.</p>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-7 py-16">
        <div class="max-w-3xl">
            <p class="font-mono text-xs text-slate-500 mb-10">Last updated: July 2026</p>

        <div class="space-y-10 text-slate-700 leading-relaxed">
            <section>
                <h2 class="font-display text-xl font-semibold text-ink mb-3">What I collect</h2>
                <p>The only information I actively collect is what you choose to send through the
                    <a href="{{ route('contact') }}" class="text-forest underline">contact form</a>:
                    your name, email address, your message, and optionally the project type and budget
                    range you select. The form also records where the enquiry came from (the page or
                    campaign that referred you) so I can understand what's actually useful to visitors.</p>
            </section>

            <section>
                <h2 class="font-display text-xl font-semibold text-ink mb-3">How I use it</h2>
                <p>I use your contact details for one thing: to reply to your enquiry and, if we work
                    together, to communicate about the project. I don't sell your information, share it
                    with advertisers, or add you to a marketing list. When you submit the form you'll get
                    an automatic confirmation email, and I'm notified so nothing gets lost.</p>
            </section>

            <section>
                <h2 class="font-display text-xl font-semibold text-ink mb-3">Cookies &amp; analytics</h2>
                <p>This site uses Google Analytics to understand which pages are helpful — which posts get
                    read, which case studies get attention. Google Analytics sets cookies, so it only loads
                    <strong>after you accept</strong> the cookie banner. If you decline, no analytics
                    cookies are set and nothing about your visit is measured. You can change your mind any
                    time by clearing this site's data in your browser.</p>
            </section>

            <section>
                <h2 class="font-display text-xl font-semibold text-ink mb-3">Who else is involved</h2>
                <p>Two third parties help run the site: an email delivery provider that sends the contact
                    confirmations and notifications, and Google Analytics (only with your consent, as
                    above). Each only receives the minimum needed to do its job.</p>
            </section>

            <section>
                <h2 class="font-display text-xl font-semibold text-ink mb-3">Keeping &amp; removing data</h2>
                <p>I keep contact enquiries as long as they're useful for the working relationship, then
                    remove them. If you'd like me to delete an enquiry you sent, just ask.</p>
            </section>

            <section>
                <h2 class="font-display text-xl font-semibold text-ink mb-3">Get in touch</h2>
                <p>Questions about any of this, or a request about your data? Email me at
                    <a href="mailto:{{ config('site.email') }}" class="text-forest underline">{{ config('site.email') }}</a>
                    and I'll sort it out.</p>
            </section>
        </div>
    </div>
</x-layouts.app>
