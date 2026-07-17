<x-layouts.app title="Ohene Adjei Effah — Full-Stack Developer for Hire | Laravel, React, WordPress"
    description="Freelance Full-Stack Developer in Accra, Ghana specializing in Laravel, React, and WordPress. Build scalable web apps and secure cloud infrastructure."
    image="images/og-homepage.png">

    <x-slot:head>
        <x-json-ld :data="[
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Person',
                'name' => config('site.name'),
                'jobTitle' => config('site.job_title'),
                'url' => route('home'),
                'email' => 'mailto:' . config('site.email'),
                'telephone' => config('site.phone'),
                'address' => ['@type' => 'PostalAddress', 'addressLocality' => config('site.locality'), 'addressCountry' => config('site.country')],
                'sameAs' => config('site.same_as'),
                'knowsAbout' => config('site.knows_about'),
            ],
            [
                '@type' => 'ProfessionalService',
                'name' => config('site.name') . ' — Web Development Services',
                'url' => route('home'),
                'areaServed' => 'Worldwide',
                'provider' => ['@type' => 'Person', 'name' => config('site.name')],
            ],
        ],
    ]" />
    </x-slot:head>

    {{-- HERO --}}
    <section class="bg-black text-white relative overflow-hidden pb-12">
        <div class="bg-aurora-animated pointer-events-none" aria-hidden="true"></div>
        <div
            class="max-w-6xl mx-auto px-7 pt-20 pb-16 grid md:grid-cols-[1.1fr_0.9fr] gap-14 items-center relative z-10">
            <div>
                @if ($available)
                    <div class="reveal">
                        <span
                            class="inline-flex items-center gap-2 font-mono text-xs text-slate-300 border border-white/15 rounded-full px-3 py-1.5 mb-6">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Available for new projects
                        </span>
                    </div>
                @endif
                <style>
                    .hero-word-rotate {
                        animation: heroWordRotate 7.5s cubic-bezier(0.16, 1, 0.3, 1) infinite;
                        opacity: 0;
                        transform: translateY(16px);
                    }

                    .hero-word-rotate:nth-child(1) {
                        animation-delay: 0s;
                    }

                    .hero-word-rotate:nth-child(2) {
                        animation-delay: 2.5s;
                    }

                    .hero-word-rotate:nth-child(3) {
                        animation-delay: 5s;
                    }

                    @keyframes heroWordRotate {
                        0% {
                            opacity: 0;
                            transform: translateY(16px);
                        }

                        5% {
                            opacity: 1;
                            transform: translateY(0);
                        }

                        28% {
                            opacity: 1;
                            transform: translateY(0);
                        }

                        33% {
                            opacity: 0;
                            transform: translateY(-16px);
                        }

                        100% {
                            opacity: 0;
                            transform: translateY(-16px);
                        }
                    }
                </style>
                <h1 class="sr-only">Full-Stack Developer & Software Engineer | Laravel, React & WordPress</h1>
                <div class="reveal font-display text-4xl md:text-5xl font-semibold leading-tight mb-5" aria-hidden="true">
                    I
                    <span class="inline-grid align-baseline">
                        <span class="col-start-1 row-start-1 text-forest hero-word-rotate">design,</span>
                        <span class="col-start-1 row-start-1 text-forest hero-word-rotate">develop,</span>
                        <span class="col-start-1 row-start-1 text-forest hero-word-rotate">deploy</span>
                        <span class="col-start-1 row-start-1 invisible" aria-hidden="true">develop,</span>
                    </span><br>
                    <span class="text-gray-400">software that works.</span>
                </div>
                <p class="reveal text-slate-300 max-w-lg mb-6">Full-stack development from first line of code to
                    long-term support. Laravel, React and WordPress products built for businesses anywhere — from Accra,
                    Ghana.</p>

                <div class="reveal flex flex-wrap items-center gap-3 text-slate-400 text-sm font-mono mb-10">
                    <span class="text-white/20">&middot;</span>
                    <span class="text-white font-semibold">{{ config('site.stats.end_users') }} End Users</span>
                    <span class="text-white/20">&middot;</span>
                    <span>{{ config('site.stats.wp_builds') }} Apps & Sites</span>
                    <span class="text-white/20">&middot;</span>
                    <span>{{ config('site.stats.traffic_lift') }} Traffic Lift</span>
                </div>

                <div class="reveal flex flex-wrap gap-4">
                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center gap-2 bg-gold text-black font-bold rounded-full px-6 py-3 hover:bg-golddeep hover:-translate-y-1 transition-premium">Start
                        a project</a>
                    <a href="{{ route('work.index') }}"
                        class="inline-flex items-center gap-2 border-2 border-rust text-rust font-bold rounded-full px-6 py-3 hover:bg-rust hover:text-black hover:-translate-y-1 transition-premium">See
                        the work</a>
                </div>
            </div>
            <div class="reveal hidden md:block">
                <x-browser-mock>
                    <div><span class="text-emerald-400">$</span> dev --status</div>
                    <div class="text-slate-400 mt-1">
                        <span class="text-white">Ohene Adjei Effah</span> · Full-Stack Developer
                    </div>
                    <div class="text-slate-400">
                        📍 Accra, Ghana · <span class="text-emerald-400">● available</span>
                    </div>
                    <div class="text-slate-400 mt-1">
                        &gt; {{ config('site.stats.years_experience') }} years · {{ config('site.stats.end_users') }}
                        users · {{ config('site.stats.wp_builds') }} apps & sites
                    </div>

                    <div class="mt-3"><span class="text-emerald-400">$</span> cat stack.yml</div>
                    <div class="text-slate-400 mt-1">
                        <span class="text-gold">backend:</span> &nbsp;Laravel · Node.js · MySQL
                    </div>
                    <div class="text-slate-400">
                        <span class="text-gold">frontend:</span> React · Livewire · Tailwind
                    </div>
                    <div class="text-slate-400">
                        <span class="text-gold">cms:</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WordPress · WooCommerce
                    </div>

                    <div class="mt-3"><span class="text-emerald-400">$</span> <span class="animate-pulse">▌</span></div>
                </x-browser-mock>
            </div>
        </div>
    </section>





    {{-- SERVICES --}}
    <section id="services" class="max-w-6xl mx-auto px-7 py-20 border-b border-black/5">
        <x-eyebrow>~/services</x-eyebrow>
        <h2 class="font-display text-3xl font-semibold mb-12 max-w-sm text-black">How I can help</h2>

        <div class="grid md:grid-cols-3 gap-14 md:gap-10">
            <div class="reveal flex gap-6 group cursor-default">
                <div class="font-display text-5xl md:text-6xl font-bold mt-1 group-hover:-translate-y-1 transition-transform duration-500"
                    style="-webkit-text-stroke: 1.5px #cbd5e1; color: transparent;">01</div>
                <div>
                    <h3
                        class="font-display text-2xl font-semibold mb-4 text-black group-hover:text-golddeep transition-colors">
                        Full-Stack Dev</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Designing fast, and scalable web
                        applications, powered by robust backend architectures.</p>
                </div>
            </div>

            <div class="reveal flex gap-6 group cursor-default">
                <div class="font-display text-5xl md:text-6xl font-bold mt-1 group-hover:-translate-y-1 transition-transform duration-500"
                    style="-webkit-text-stroke: 1.5px #cbd5e1; color: transparent;">02</div>
                <div>
                    <h3
                        class="font-display text-2xl font-semibold mb-4 text-black group-hover:text-forest transition-colors">
                        Cloud & DevOps</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Build and manage scalable infrastructure with
                        automated CI/CD
                        pipelines to ensure 99.9% uptime.</p>
                </div>
            </div>

            <div class="reveal flex gap-6 group cursor-default">
                <div class="font-display text-5xl md:text-6xl font-bold mt-1 group-hover:-translate-y-1 transition-transform duration-500"
                    style="-webkit-text-stroke: 1.5px #cbd5e1; color: transparent;">03</div>
                <div>
                    <h3
                        class="font-display text-2xl font-semibold mb-4 text-black group-hover:text-rust transition-colors">
                        CMS & Commerce</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Fast, reliable, and easily manageable web
                        solutions for business, with WordPress and WooCommerce.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURED WORK --}}
    @if ($projects->isNotEmpty())
        <section class="max-w-6xl mx-auto px-7 py-20">
            <div class="reveal flex items-end justify-between flex-wrap gap-4 mb-10">
                <div>
                    <x-eyebrow>~/work</x-eyebrow>
                    <h2 class="font-display text-3xl font-semibold text-black">Selected work</h2>
                </div>
                <a href="{{ route('work.index') }}" class="font-semibold text-black hover:text-rust transition-colors">View
                    all work &rarr;</a>
            </div>
            <div class="flex flex-col gap-10">
                @foreach ($projects as $project)
                    <div class="reveal">
                        <x-case-study-card :project="$project" :accent="['gold', 'forest', 'rust'][$loop->index % 3]" />
                    </div>
                @endforeach
            </div>
        </section>


    @endif





    {{-- BLOG PREVIEW --}}
    @if ($posts->isNotEmpty())
        <section class="max-w-6xl mx-auto px-7 py-20">
            <div class="reveal flex items-end justify-between flex-wrap gap-4 mb-10">
                <div>
                    <x-eyebrow>~/blog</x-eyebrow>
                    <h2 class="font-display text-3xl font-semibold text-black">Notes & insights</h2>
                </div>
                <a href="{{ route('blog.index') }}"
                    class="font-semibold text-black hover:text-forest transition-colors">Read the blog &rarr;</a>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    <div class="reveal h-full {{ ['delay-0', 'delay-100'][$loop->index % 2] }}">
                        <x-blog-card :post="$post" :accent="['gold', 'forest'][$loop->index % 2]" />
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- VIDEOS --}}
    @if(isset($videos) && $videos->isNotEmpty())
        <section class="max-w-6xl mx-auto px-7 pb-20">
            <div class="reveal flex items-end justify-between flex-wrap gap-4 mb-10">
                <div>
                    <x-eyebrow>~/videos</x-eyebrow>
                    <h2 class="font-display text-3xl font-semibold text-black">Dev videos</h2>
                </div>
                <a href="{{ route('videos') }}" class="font-semibold text-black hover:text-forest transition-colors">Watch
                    all &rarr;</a>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($videos as $video)
                    <div class="reveal">
                        <x-video-card :video="$video" />
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- CONTACT CTA --}}
</x-layouts.app>