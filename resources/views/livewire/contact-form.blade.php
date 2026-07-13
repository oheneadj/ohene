<div>
    @if ($submitted)
        <div class="bg-white border border-forest/30 rounded-[2rem] p-10 md:p-14 text-center shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
            <div class="w-16 h-16 rounded-full bg-forest/10 text-forest flex items-center justify-center mx-auto mb-6 text-3xl">&checkmark;</div>
            <h3 class="font-display text-2xl font-semibold mb-3">Message sent — thank you.</h3>
            <p class="text-slate-600 text-lg">I'll get back to you within one business day. A confirmation is on its way to your inbox.</p>
        </div>
    @else
        <form wire:submit="submit" class="bg-white border border-black/5 rounded-[2rem] p-6 md:p-10 grid gap-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
            {{-- Honeypot: hidden from people, tempting to bots. --}}
            <div class="hidden" aria-hidden="true">
                <label>Website<input type="text" wire:model="website" tabindex="-1" autocomplete="off"></label>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block font-mono text-xs uppercase text-slate-500 mb-2">Name</label>
                    <input id="name" type="text" wire:model="name" class="w-full border border-black/10 rounded-xl px-4 py-3 focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-colors">
                    @error('name') <p class="text-rust text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="block font-mono text-xs uppercase text-slate-500 mb-2">Email</label>
                    <input id="email" type="email" wire:model="email" class="w-full border border-black/10 rounded-xl px-4 py-3 focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-colors">
                    @error('email') <p class="text-rust text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="project_type" class="block font-mono text-xs uppercase text-slate-500 mb-2">Project type</label>
                    <select id="project_type" wire:model="project_type" class="w-full border border-black/10 rounded-xl px-4 py-3 focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-colors">
                        <option value="">Select one (optional)</option>
                        @foreach ($projectTypes as $type)
                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                        @endforeach
                    </select>
                    @error('project_type') <p class="text-rust text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="budget_range" class="block font-mono text-xs uppercase text-slate-500 mb-2">Budget</label>
                    <select id="budget_range" wire:model="budget_range" class="w-full border border-black/10 rounded-xl px-4 py-3 focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-colors">
                        <option value="">Select one (optional)</option>
                        @foreach ($budgetRanges as $range)
                            <option value="{{ $range->value }}">{{ $range->label() }}</option>
                        @endforeach
                    </select>
                    @error('budget_range') <p class="text-rust text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="message" class="block font-mono text-xs uppercase text-slate-500 mb-2">What are you building?</label>
                <textarea id="message" wire:model="message" rows="5" class="w-full border border-black/10 rounded-xl px-4 py-3 focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-colors"></textarea>
                @error('message') <p class="text-rust text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="inline-flex items-center justify-center w-full sm:w-auto gap-2 bg-black text-white border border-black font-semibold rounded-full px-8 py-3.5 hover:bg-transparent hover:text-black transition-premium disabled:opacity-60" wire:loading.attr="disabled" wire:target="submit">
                    <span wire:loading.remove wire:target="submit">Send message</span>
                    <span wire:loading wire:target="submit">Sending…</span>
                </button>
            </div>
        </form>
    @endif
</div>
