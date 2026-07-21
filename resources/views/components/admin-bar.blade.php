@php
    $post = request()->route('post');
    $project = request()->route('project');
@endphp

<div class="bg-[#111827] text-white px-4 h-10 text-sm flex items-center justify-between z-[100] relative border-b border-gray-800">
    <div class="flex items-center gap-6 h-full">
        <a href="{{ url('/') }}" class="font-bold flex items-center gap-2 hover:text-[#a3e635] transition-colors h-full">
            <x-heroicon-o-globe-alt class="w-4 h-4" />
            <span class="hidden sm:inline">{{ config('app.name') }}</span>
        </a>
        
        <div class="h-4 w-px bg-gray-700 hidden sm:block"></div>

        <a href="{{ url('/admin') }}" class="flex items-center gap-1.5 hover:text-[#a3e635] transition-colors h-full">
            <x-heroicon-o-squares-2x2 class="w-4 h-4" />
            <span class="hidden sm:inline">Dashboard</span>
        </a>

        <div class="flex items-center gap-3">
            <a href="{{ route('filament.admin.resources.posts.create') }}" class="flex items-center gap-1 hover:text-[#a3e635] transition-colors">
                <x-heroicon-o-plus class="w-4 h-4" />
                <span class="hidden md:inline">New Post</span>
            </a>
            <a href="{{ route('filament.admin.resources.projects.create') }}" class="flex items-center gap-1 hover:text-[#a3e635] transition-colors">
                <x-heroicon-o-plus class="w-4 h-4" />
                <span class="hidden md:inline">New Project</span>
            </a>
        </div>

        @if($post && $post instanceof \App\Models\Post)
            <div class="h-4 w-px bg-gray-700"></div>
            <a href="{{ route('filament.admin.resources.posts.edit', ['record' => $post]) }}" class="flex items-center gap-1.5 text-[#a3e635] hover:text-white transition-colors font-medium">
                <x-heroicon-o-pencil-square class="w-4 h-4" />
                Edit Post
            </a>
        @endif

        @if($project && $project instanceof \App\Models\Project)
            <div class="h-4 w-px bg-gray-700"></div>
            <a href="{{ route('filament.admin.resources.projects.edit', ['record' => $project]) }}" class="flex items-center gap-1.5 text-[#a3e635] hover:text-white transition-colors font-medium">
                <x-heroicon-o-pencil-square class="w-4 h-4" />
                Edit Project
            </a>
        @endif
    </div>

    <div class="flex items-center gap-4 h-full">
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center text-xs font-bold text-white">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
            <span class="hidden sm:inline text-gray-300">Howdy, {{ auth()->user()->name ?? 'Admin' }}</span>
        </div>
        
        <form action="{{ route('filament.admin.auth.logout') }}" method="POST" class="h-full flex items-center">
            @csrf
            <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors flex items-center gap-1">
                <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4" />
                <span class="hidden sm:inline">Log Out</span>
            </button>
        </form>
    </div>
</div>
