<div style="background-color: #171717; color: #cbd5e1; padding: 0.5rem 1rem; font-size: 0.875rem; display: flex; justify-content: space-between; align-items: center; z-index: 100; position: relative; font-family: ui-sans-serif, system-ui, sans-serif; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div style="display: flex; align-items: center; gap: 1.25rem;">
        <a href="{{ route('home') }}" style="color: white; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; text-decoration: none;" onmouseover="this.style.color='#a3e635'" onmouseout="this.style.color='white'">
            <svg style="width: 1rem; height: 1rem; color: #a3e635;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
            </svg>
            {{ config('site.name', 'Ohene Adjei Effah') }}
        </a>
        <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 0.375rem; color: #cbd5e1; text-decoration: none;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#cbd5e1'">
            <svg style="width: 1rem; height: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            View Public Site
        </a>
    </div>
</div>
