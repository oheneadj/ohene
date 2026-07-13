// Signal that JS is running. The scroll-reveal styles are scoped to `.js`, so
// without JS (crawlers, failures, disabled) the page renders fully visible —
// content is never gated on JS execution (requirements FR1).
document.documentElement.classList.add('js');

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

// Mobile nav toggle — mirrors the static site's menu behaviour.
const navToggle = document.getElementById('navToggle');
const mobileMenu = document.getElementById('mobileMenu');

if (navToggle && mobileMenu) {
    navToggle.addEventListener('click', () => {
        const isOpen = mobileMenu.classList.toggle('flex');
        mobileMenu.classList.toggle('hidden');
        navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
}

// Scroll-reveal: fade sections in as they enter the viewport.
// Respects prefers-reduced-motion (the CSS shows everything immediately there).
const revealables = document.querySelectorAll('.reveal');

if (revealables.length > 0 && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 },
    );

    revealables.forEach((el) => observer.observe(el));
}

// Stat counter animation
const statCounters = document.querySelectorAll('.stat-counter');

if (statCounters.length > 0 && 'IntersectionObserver' in window) {
    const counterObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-target'), 10);
                    const shouldFormat = el.getAttribute('data-format') === 'true';
                    const format = (n) => (shouldFormat ? n.toLocaleString('en-US') : String(n));

                    // Reduced motion: show the final figure instantly, no count-up.
                    if (prefersReducedMotion) {
                        el.innerText = format(target);
                        counterObserver.unobserve(el);
                        return;
                    }

                    const duration = 2000; // ms
                    const frameRate = 30; // ms
                    const totalFrames = Math.round(duration / frameRate);
                    let frame = 0;

                    const counter = setInterval(() => {
                        frame++;
                        const progress = frame / totalFrames;
                        // easeOutExpo curve for smooth slow down at the end
                        const currentCount = progress === 1 ? target : target * (1 - Math.pow(2, -10 * progress));

                        el.innerText = format(Math.round(currentCount));

                        if (frame === totalFrames) {
                            clearInterval(counter);
                        }
                    }, frameRate);

                    counterObserver.unobserve(el);
                }
            });
        },
        { threshold: 0.5 }
    );

    statCounters.forEach((el) => counterObserver.observe(el));
}

// --- Analytics event tracking (MR3) ---------------------------------------
// Provider-agnostic: forwards to whichever analytics script is loaded (or no-ops
// in dev when none is). The actual provider is chosen via config/site.php.
function track(event, props = {}) {
    if (typeof window.gtag === 'function') {
        window.gtag('event', event, props);
    } else if (typeof window.plausible === 'function') {
        window.plausible(event, { props });
    }
}

// Delegated click tracking: explicit data-track events, resume downloads, and
// any outbound link (e.g. GitHub / LinkedIn).
document.addEventListener('click', (e) => {
    const link = e.target.closest('a');
    if (!link) {
        return;
    }

    if (link.dataset.track) {
        track(link.dataset.track);
        return;
    }

    const href = link.getAttribute('href') || '';
    if (/^https?:\/\//i.test(href) && !href.includes(window.location.host)) {
        track('outbound_click', { url: href });
    }
});

// Scroll to Top
const scrollToTopBtn = document.getElementById('scrollToTop');
if (scrollToTopBtn) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 500) {
            scrollToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
            scrollToTopBtn.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
        } else {
            scrollToTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
            scrollToTopBtn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
        }
    }, { passive: true });

    scrollToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// Contact form success dispatches a Livewire event we forward to analytics.
document.addEventListener('livewire:init', () => {
    if (window.Livewire) {
        window.Livewire.on('lead-submitted', () => track('contact_submitted'));
    }
});

// --- Google Analytics 4 with cookie consent -------------------------------
// GA4 sets cookies, so it only loads after the visitor accepts the banner.
// Cookieless providers (Cloudflare/Plausible) skip all of this.
function loadGoogleAnalytics(id) {
    if (!id || window.gtag) {
        return;
    }
    const script = document.createElement('script');
    script.async = true;
    script.src = `https://www.googletagmanager.com/gtag/js?id=${id}`;
    document.head.appendChild(script);

    window.dataLayer = window.dataLayer || [];
    window.gtag = function () {
        window.dataLayer.push(arguments);
    };
    window.gtag('js', new Date());
    window.gtag('config', id);
}

(function initAnalyticsConsent() {
    const provider = document.querySelector('meta[name="analytics-provider"]')?.content;
    if (provider !== 'ga4') {
        return;
    }

    const ga4Id = document.querySelector('meta[name="analytics-ga4-id"]')?.content;
    const consent = localStorage.getItem('analytics-consent');
    const banner = document.getElementById('cookie-consent');

    if (consent === 'granted') {
        loadGoogleAnalytics(ga4Id);
        return;
    }

    if (consent === 'denied' || !banner) {
        return;
    }

    banner.classList.remove('hidden');

    document.getElementById('cookie-accept')?.addEventListener('click', () => {
        localStorage.setItem('analytics-consent', 'granted');
        banner.classList.add('hidden');
        loadGoogleAnalytics(ga4Id);
    });

    document.getElementById('cookie-decline')?.addEventListener('click', () => {
        localStorage.setItem('analytics-consent', 'denied');
        banner.classList.add('hidden');
    });
})();
