<x-layouts.app title="About Ohene Adjei Effah — Full-Stack Web Developer"
    description="Seven years building Laravel, React and WordPress software — bio, track record, skills and education of full-stack developer Ohene Adjei Effah.">

    <x-slot:head>
        <x-json-ld :data="[
            [
                '@context' => 'https://schema.org',
                '@type' => 'AboutPage',
                'name' => 'About Ohene Adjei Effah',
                'url' => route('about'),
                'mainEntity' => [
                    '@type' => 'Person',
                    'name' => config('site.name'),
                    'jobTitle' => config('site.job_title'),
                    'image' => asset('images/ohene-adjei-effah-about.jpg'),
                    'sameAs' => config('site.same_as'),
                ]
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'About', 'item' => route('about')],
                ]
            ]
        ]" />
    </x-slot:head>

    <section class="bg-black text-white relative overflow-hidden pt-24 pb-24 md:pb-32 border-b border-white/10">
        <div class="bg-aurora-animated pointer-events-none opacity-40" aria-hidden="true"></div>
        <div class="max-w-6xl mx-auto px-7 relative z-10">
            <p class="font-mono text-xs uppercase tracking-widest text-forest mb-4">&rsaquo; ~/about</p>
            <h1 class="font-display text-3xl md:text-5xl font-semibold mb-6 leading-tight">The developer behind the work
            </h1>

            <div class="flex flex-wrap items-center justify-between gap-6">
                <div class="flex flex-wrap items-center gap-3 text-slate-400 text-sm font-mono">
                    <span class="text-white font-semibold">{{ config('site.stats.years_experience') }} Years Exp</span>
                    <span class="text-white/20">&middot;</span>
                    <span class="text-white font-semibold">{{ config('site.stats.end_users') }} End Users</span>
                    <span class="text-white/20">&middot;</span>
                    <span>{{ config('site.stats.wp_builds') }} WP Builds</span>
                    <span class="text-white/20">&middot;</span>
                    <span>100% Delivery</span>
                </div>

                {{-- Social Links --}}
                <div class="flex items-center gap-3">
                    <a href="https://twitter.com/oheneadj" target="_blank" rel="noopener"
                        class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-slate-300 hover:text-white hover:border-white hover:bg-white/10 transition-premium"
                        title="X (Twitter)">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.008 4.076H5.078z" />
                        </svg>
                    </a>
                    <a href="https://linkedin.com/in/oheneadj" target="_blank" rel="noopener"
                        class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-slate-300 hover:text-white hover:border-white hover:bg-white/10 transition-premium"
                        title="LinkedIn">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="https://github.com/oheneadj" target="_blank" rel="noopener"
                        class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-slate-300 hover:text-white hover:border-white hover:bg-white/10 transition-premium"
                        title="GitHub">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="https://youtube.com/@oheneadj" target="_blank" rel="noopener"
                        class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-slate-300 hover:text-white hover:border-white hover:bg-white/10 transition-premium"
                        title="YouTube">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M21.582,6.186c-0.23-0.86-0.908-1.538-1.768-1.768C18.254,4,12,4,12,4s-6.254,0-7.814,0.418 c-0.86,0.23-1.538,0.908-1.768,1.768C2,7.746,2,12,2,12s0,4.254,0.418,5.814c0.23,0.86,0.908,1.538,1.768,1.768 C5.746,20,12,20,12,20s6.254,0,7.814-0.418c0.86-0.23,1.538-0.908,1.768-1.768C22,16.254,22,12,22,12S22,7.746,21.582,6.186z M9.6,15.6V8.4l6.4,3.6L9.6,15.6z" />
                        </svg>
                    </a>
                    <a href="{{ asset('Ohene_Adjei_Effah_Resume.pdf') }}" download data-track="resume_download"
                        class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-slate-300 hover:text-white hover:border-white hover:bg-white/10 transition-premium"
                        title="Download Resume">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="max-w-6xl mx-auto px-7 py-20 md:py-32">
        <h2
            class="reveal font-display text-4xl md:text-5xl lg:text-6xl mb-8 leading-[1.15] max-w-5xl text-black tracking-tight">
            <span class="text-slate-400 font-light">Building robust digital platforms through</span>
            modern engineering and scalable architecture.
        </h2>

        <div class="grid md:grid-cols-[1.3fr_1fr] gap-14 items-center mb-12">
            <div class="order-2 md:order-1 reveal delay-100">
                <p class="text-slate-600 text-lg mb-6 leading-relaxed">I'm a full-stack web developer with {{ date('Y') - config('site.stats.career_start_year') }}+ years of experience shipping production web applications across fintech, EdTech, logistics, and
                    retail. I've delivered systems used by over 10,000 users, drove a 40% traffic increase for clients,
                    and built regulatory-compliant tools for Ghanaian financial institutions.</p>
                <p class="text-slate-600 text-lg mb-8 leading-relaxed">I specialize in Laravel, Livewire, and API
                    design, with deep experience in Vue.js, React, and AWS cloud infrastructure. Beyond building
                    reliable code, I'm an active tech educator who has trained 200+ students and facilitated national
                    digital literacy programmes under Ghana's Digitalize Ghana initiative.</p>

                <a href="{{ route('work.index') }}"
                    class="inline-flex items-center gap-2 border border-black/20 rounded-full px-8 py-3.5 text-sm font-semibold hover:bg-black hover:text-white transition-premium hover:-translate-y-1 shadow-sm">
                    View my work &rarr;
                </a>
            </div>
            <div class="order-1 md:order-2 reveal delay-200 relative group mb-8 md:mb-0">
                <div
                    class="absolute inset-0 bg-forest/20 blur-3xl rounded-full group-hover:bg-gold/30 transition-colors duration-700">
                </div>
                @php
                    $aboutImagePath = \App\Models\Setting::get('about_image');
                    $aboutImageUrl = $aboutImagePath
                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($aboutImagePath)
                        : asset('images/profile.png');
                @endphp
                <img src="{{ $aboutImageUrl }}" alt="Ohene Adjei Effah"
                    class="relative z-10 w-full h-[400px] md:h-[500px] object-cover rounded-[2rem] shadow-xl grayscale group-hover:grayscale-0 transition-all duration-700">
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-7 py-16 md:py-24 border-t border-black/5">
        <div class="grid md:grid-cols-3 gap-14 md:gap-10">
            <div class="reveal flex gap-6 group cursor-default">
                <div class="font-display text-5xl md:text-6xl font-bold mt-1 group-hover:-translate-y-1 transition-transform duration-500"
                    style="-webkit-text-stroke: 1.5px #cbd5e1; color: transparent;">01</div>
                <div>
                    <h3
                        class="font-display text-2xl font-semibold mb-4 text-black group-hover:text-forest transition-colors">
                        Full-Stack Dev</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Designing intuitive and engaging user experiences
                        with React and Vue that seamlessly blend form and function, powered by robust backend
                        architectures in Laravel and Node.js.</p>
                </div>
            </div>

            <div class="reveal flex gap-6 group cursor-default">
                <div class="font-display text-5xl md:text-6xl font-bold mt-1 group-hover:-translate-y-1 transition-transform duration-500"
                    style="-webkit-text-stroke: 1.5px #cbd5e1; color: transparent;">02</div>
                <div>
                    <h3
                        class="font-display text-2xl font-semibold mb-4 text-black group-hover:text-forest transition-colors">
                        Cloud & DevOps</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Transforming local code into highly available
                        digital realities. I build and manage scalable infrastructure on AWS with automated CI/CD
                        pipelines to ensure 99.9% uptime.</p>
                </div>
            </div>

            <div class="reveal flex gap-6 group cursor-default">
                <div class="font-display text-5xl md:text-6xl font-bold mt-1 group-hover:-translate-y-1 transition-transform duration-500"
                    style="-webkit-text-stroke: 1.5px #cbd5e1; color: transparent;">03</div>
                <div>
                    <h3
                        class="font-display text-2xl font-semibold mb-4 text-black group-hover:text-forest transition-colors">
                        CMS & Commerce</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Crafting custom WordPress and WooCommerce
                        solutions for businesses that need fast, reliable, and easily manageable digital storefronts
                        with deep technical optimization.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-7 py-16 md:py-24 overflow-hidden border-t border-black/5 mb-10">
        <style>
            .tech-icon-container:hover svg {
                color: var(--brand-color) !important;
            }
        </style>
        <div
            class="reveal flex flex-wrap justify-center gap-8 md:gap-14 items-center opacity-70 hover:opacity-100 transition-opacity duration-700">
            <!-- Frameworks & Frontend -->
            <div class="-rotate-3"><x-tech-icon icon="laravel" color="FF2D20" name="Laravel" /></div>
            <div class="rotate-2"><x-tech-icon icon="livewire" color="4E56A6" name="Livewire" /></div>
            <div class="-rotate-2"><x-tech-icon icon="alpinedotjs" color="8BC0D0" name="Alpine.js" /></div>
            <div class="rotate-3"><x-tech-icon icon="tailwindcss" color="06B6D4" name="Tailwind CSS" /></div>
            <div class="-rotate-1"><x-tech-icon icon="vuedotjs" color="4FC08D" name="Vue.js" /></div>
            <div class="rotate-2"><x-tech-icon icon="react" color="61DAFB" name="React" /></div>
            <div class="-rotate-3"><x-tech-icon icon="nodedotjs" color="339933" name="Node.js" /></div>

            <!-- Infrastructure, DB & Tools -->
            <div class="rotate-2"><x-tech-icon icon="mysql" color="4479A1" name="MySQL" /></div>
            <div class="-rotate-2"><x-tech-icon icon="redis" color="DC382D" name="Redis" /></div>
            <div class="rotate-3"><x-tech-icon icon="wordpress" color="21759B" name="WordPress" /></div>
            <div class="-rotate-1"><x-tech-icon icon="amazonaws" color="232F3E" name="AWS" /></div>
            <div class="rotate-2"><x-tech-icon icon="docker" color="2496ED" name="Docker" /></div>
            <div class="-rotate-3"><x-tech-icon icon="github" color="181717" name="GitHub" /></div>
            <div class="rotate-2"><x-tech-icon icon="sentry" color="362D59" name="Sentry" /></div>
        </div>
    </section>

</x-layouts.app>