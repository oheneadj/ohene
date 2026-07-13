<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Popular Pages — Last 28 Days
        </x-slot>

        <div class="overflow-x-auto mt-2">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                        <th class="py-3 px-4">Page Title & Path</th>
                        <th class="py-3 px-4 text-right">Views</th>
                        <th class="py-3 px-4 text-right">Sessions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($this->rows as $row)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/50 transition-colors duration-200">
                            <td class="py-3 px-4">
                                <div class="font-medium text-gray-900 dark:text-white truncate max-w-md">
                                    {{ $row['title'] }}
                                </div>
                                <div class="text-xs text-gray-400 dark:text-gray-500 font-mono truncate max-w-md mt-0.5">
                                    <a href="{{ $row['path'] }}" target="_blank" class="hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                                        {{ $row['path'] }}
                                    </a>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-right text-gray-700 dark:text-gray-300 font-semibold">
                                {{ $row['views'] }}
                            </td>
                            <td class="py-3 px-4 text-right text-gray-500 dark:text-gray-400 font-medium">
                                {{ $row['sessions'] }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 text-center text-gray-400 dark:text-gray-500 text-sm">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-8 h-8 text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span>No page view data available.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
