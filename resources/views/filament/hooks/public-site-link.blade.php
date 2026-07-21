<div style="width: 100%; background-color: #111827; color: #ffffff; padding: 0.5rem 1rem; font-size: 0.875rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #1f2937; z-index: 50; position: relative;">
    <div style="display: flex; align-items: center; gap: 0.5rem;">
        <svg style="width: 1rem; height: 1rem; color: #9ca3af;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
        </svg>
        <a href="{{ url('/') }}" target="_blank" style="color: #ffffff; text-decoration: none; font-weight: 500;" onmouseover="this.style.color='#a3e635'" onmouseout="this.style.color='#ffffff'">
            View Public Site
        </a>
    </div>
    <div style="font-size: 0.75rem; color: #9ca3af;">
        You are currently managing {{ config('app.name') }}
    </div>
</div>
