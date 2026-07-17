<x-filament-widgets::widget>
    <x-filament::section>
        <div style="display: flex; align-items: flex-start; gap: 1rem;">
            <!-- Icon -->
            <div style="flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 3.5rem; height: 3.5rem; border-radius: 0.75rem; background-color: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                <x-heroicon-s-star style="width: 1.75rem; height: 1.75rem;" />
            </div>
            
            <!-- Content -->
            <div style="flex: 1; min-width: 0;">
                <p style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; color: #3b82f6; text-transform: uppercase; margin-bottom: 0.25rem; margin-top: 0;">
                    Top Case Study
                </p>
                <h3 style="font-size: 1.125rem; font-weight: 700; line-height: 1.25; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: inherit;">
                    {{ $projectTitle }}
                </h3>
                <div style="display: flex; align-items: center; gap: 0.375rem; margin-top: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #6b7280;">
                    <x-heroicon-m-eye style="width: 1rem; height: 1rem;" />
                    <span>{{ number_format($projectViews) }} views</span>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>