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
            <p class="text-slate-300 max-w-xl text-lg mb-8">A few projects that show how I approach a problem, from first requirement to what it delivered.</p>
            
            <div class="flex flex-wrap items-center gap-4">
                <div class="inline-flex items-center gap-2 bg-white/10 text-white font-mono text-sm font-semibold tracking-wide rounded-full px-5 py-2">
                    <span class="w-2 h-2 rounded-full bg-forest animate-pulse"></span>
                    {{ \App\Models\Project::count() }} Case Studies
                </div>
                <a href="https://github.com/oheneadj" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 border border-white/20 text-slate-300 font-mono text-sm font-medium rounded-full px-5 py-2 hover:bg-white/10 hover:text-white hover:border-white/30 transition-premium">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                    GitHub
                </a>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-7 py-10">
        {{-- Filter Bar --}}
        <div class="flex flex-wrap items-center gap-2 mb-10 pb-6 border-b border-black/5">
            @php
                $filters = ['Laravel', 'React', 'Vue', 'WordPress'];
            @endphp
            <a href="{{ route('work.index') }}" 
               class="px-5 py-2 rounded-full font-mono text-xs uppercase tracking-widest transition-colors {{ empty($currentFilter) ? 'bg-black text-white font-bold' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800' }}">
               All
            </a>
            @foreach($filters as $filter)
                <a href="{{ route('work.index', ['filter' => $filter]) }}" 
                   class="px-5 py-2 rounded-full font-mono text-xs uppercase tracking-widest transition-colors {{ $currentFilter === $filter ? 'bg-black text-white font-bold' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800' }}">
                   {{ $filter }}
                </a>
            @endforeach
        </div>

        @if ($projects->isEmpty())
            <p class="text-slate-500">No projects found for this filter. Check back soon.</p>
        @else
            <div class="flex flex-col gap-10" id="projects-container">
                @foreach ($projects as $project)
                    <div class="project-item">
                        <x-case-study-card :project="$project" :accent="['gold', 'forest', 'rust'][$loop->index % 3]" />
                    </div>
                @endforeach
            </div>

            <div id="load-more-container" class="mt-12 flex justify-center">
                @if ($projects->hasMorePages())
                    <button 
                        data-url="{{ $projects->nextPageUrl() }}"
                        onclick="loadMoreProjects(this)"
                        class="inline-flex items-center gap-2 bg-black border border-black text-white rounded-full px-8 py-3 hover:bg-slate-800 hover:border-slate-800 transition-all font-semibold font-display shadow-sm group"
                    >
                        <span class="btn-text">Load more projects</span>
                        <svg class="w-4 h-4 group-hover:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                @endif
            </div>

            <script>
                function loadMoreProjects(button) {
                    const url = button.getAttribute('data-url');
                    if (!url) return;
                    
                    const btnText = button.querySelector('.btn-text');
                    btnText.innerText = 'Loading...';
                    button.disabled = true;
                    button.classList.add('opacity-70', 'cursor-not-allowed');

                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            
                            const newProjects = doc.querySelectorAll('.project-item');
                            const container = document.getElementById('projects-container');
                            
                            newProjects.forEach(item => {
                                container.appendChild(item.cloneNode(true));
                            });

                            const newLoadMore = doc.getElementById('load-more-container');
                            const currentLoadMore = document.getElementById('load-more-container');
                            
                            if (newLoadMore) {
                                currentLoadMore.innerHTML = newLoadMore.innerHTML;
                            } else {
                                currentLoadMore.innerHTML = '';
                            }
                        })
                        .catch(error => {
                            console.error('Error loading more projects:', error);
                            btnText.innerText = 'Error loading. Try again.';
                            button.disabled = false;
                            button.classList.remove('opacity-70', 'cursor-not-allowed');
                        });
                }
            </script>
        @endif
    </section>

</x-layouts.app>
