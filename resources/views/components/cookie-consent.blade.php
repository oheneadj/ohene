@php
    // Only cookie-setting providers need a consent banner. Cookieless ones don't.
    $needsConsent = config('site.analytics.provider') === 'ga4' && config('site.analytics.ga4_id');
@endphp

@if ($needsConsent)
    <div id="cookie-consent" role="dialog" aria-label="Cookie consent" aria-live="polite"
        class="hidden fixed bottom-6 inset-x-6 md:right-auto md:left-8 md:max-w-[400px] z-[60] bg-black/90 backdrop-blur-xl border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-3xl p-6 transform transition-all duration-500 translate-y-0 opacity-100">
        <div class="flex items-start gap-4 mb-6">
            <div class="bg-white/10 rounded-full p-2.5 shrink-0 text-gold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
            </div>
            <div>
                <h4 class="text-white font-display font-semibold text-lg mb-1">Privacy & Cookies</h4>
                <p class="text-sm text-slate-300 leading-relaxed">
                    I use Google Analytics to understand what's useful on this site. It sets cookies to help me improve the experience.
                    <a href="{{ route('privacy') }}" class="text-gold hover:text-golddeep underline decoration-gold/30 underline-offset-2 transition-colors">Learn more</a>.
                </p>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="button" id="cookie-accept" class="flex-1 bg-gold text-black font-bold rounded-full px-5 py-2.5 text-sm hover:bg-golddeep hover:-translate-y-0.5 transition-premium shadow-[0_0_15px_rgba(251,191,36,0.3)]">Accept</button>
            <button type="button" id="cookie-decline" class="flex-1 bg-white/5 border border-white/10 text-white font-semibold rounded-full px-5 py-2.5 text-sm hover:bg-white/10 hover:-translate-y-0.5 transition-premium">Decline</button>
        </div>
    </div>
@endif
