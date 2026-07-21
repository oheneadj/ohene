<div class="fi-topbar-custom w-full bg-gray-900 text-white px-4 py-2 text-sm flex items-center justify-between border-b border-gray-800">
    <div class="flex items-center gap-2">
        <x-heroicon-o-globe-alt class="w-4 h-4 text-gray-400" />
        <a href="{{ url('/') }}" target="_blank" class="hover:text-primary-400 transition-colors font-medium">
            View Public Site
        </a>
    </div>
    <div class="text-xs text-gray-400">
        You are currently managing {{ config('app.name') }}
    </div>
</div>
