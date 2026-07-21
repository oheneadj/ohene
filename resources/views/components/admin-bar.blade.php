@auth
    <div class="bg-[#1e1e1e] text-slate-300 px-4 py-2.5 text-sm flex flex-wrap gap-4 justify-between items-center z-[100] relative font-sans border-b border-black/50 shadow-md">
        <div class="flex items-center gap-5 flex-wrap">
            <a href="{{ url('/admin') }}" class="text-white font-semibold flex items-center gap-2 hover:text-forest transition-colors">
                <svg class="w-4 h-4 text-forest" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
                {{ config('site.name', 'Ohene Adjei Effah') }}
            </a>
            
            <a href="{{ url('/admin') }}" class="flex items-center gap-1.5 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <div class="hidden sm:block h-4 w-px bg-white/20"></div>

            <a href="{{ url('/admin/posts/create') }}" class="flex items-center gap-1.5 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Post
            </a>
            
            <a href="{{ url('/admin/projects/create') }}" class="flex items-center gap-1.5 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Project
            </a>
            
            @if(request()->routeIs('blog.show') && request()->route('post'))
                <div class="hidden sm:block h-4 w-px bg-white/20"></div>
                <a href="{{ url('/admin/posts/' . request()->route('post')->ulid . '/edit') }}" class="flex items-center gap-1.5 hover:text-white transition-colors text-rust">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Post
                </a>
            @elseif(request()->routeIs('work.show') && request()->route('project'))
                <div class="hidden sm:block h-4 w-px bg-white/20"></div>
                <a href="{{ url('/admin/projects/' . request()->route('project')->ulid . '/edit') }}" class="flex items-center gap-1.5 hover:text-white transition-colors text-rust">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Project
                </a>
            @endif
        </div>
        
        <div class="flex items-center gap-4">
            <span class="flex items-center gap-2">
                <div class="w-5 h-5 rounded-full bg-forest text-black flex items-center justify-center font-bold text-xs uppercase">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <span class="hidden sm:inline">Howdy, {{ explode(' ', auth()->user()->name ?? 'Admin')[0] }}</span>
            </span>
            <form method="POST" action="{{ route('filament.admin.auth.logout') }}">
                @csrf
                <button type="submit" class="hover:text-rust transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Log Out
                </button>
            </form>
        </div>
    </div>
@endauth
