@props(['title' => 'ohene@dev — zsh'])

{{-- Terminal/browser chrome mock used in the hero (design motif, req 4.1). --}}
<div class="bg-inksoft border border-white/10 rounded-xl overflow-hidden ring-1 ring-white/5">
    <div class="flex items-center gap-2 px-4 py-3 border-b border-white/10">
        <span class="w-2.5 h-2.5 rounded-full bg-[#E4644B]"></span>
        <span class="w-2.5 h-2.5 rounded-full bg-[#E8B84B]"></span>
        <span class="w-2.5 h-2.5 rounded-full bg-[#4BAE7A]"></span>
        <p class="font-mono text-xs text-slate-400 ml-2">{{ $title }}</p>
    </div>
    <div class="p-6 font-mono text-sm leading-loose">
        {{ $slot }}
    </div>
</div>
