/**
 * ============================================================================
 * LIVEpro Software Solutions - Modern Corporate Design System
 * Client-side interactivity, motion & micro-interactions
 * ----------------------------------------------------------------------------
 * Everything here is progressive enhancement: with JS disabled the site still
 * renders and works. Motion respects the user's "reduce motion" preference.
 * ============================================================================
 */

/* ---------------------------------------------------------------------------
   0. SHARED HELPERS
   --------------------------------------------------------------------------- */
const LV_PREFERS_REDUCED_MOTION = window.matchMedia
    ? window.matchMedia('(prefers-reduced-motion: reduce)').matches
    : false;

/* ---------------------------------------------------------------------------
   1. BOOTSTRAP THE UI ENHANCEMENTS
   --------------------------------------------------------------------------- */
document.addEventListener('DOMContentLoaded', () => {
    initMobileNav();
    initHeaderScrollState();
    initScrollProgress();
    initBackToTop();
    initScrollReveal();
    initCounters();
    initPasswordToggles();
    initModalA11y();
    initSmoothAnchors();

    if (document.getElementById('estimatorWidget')) {
        calculateEstimate();
    }
});

/* ---------------------------------------------------------------------------
   2. MOBILE NAVIGATION
   --------------------------------------------------------------------------- */
function initMobileNav() {
    const hamburgerBtns = document.querySelectorAll('.hamburger, #mobileHamburger');
    const navLinks = document.getElementById('navLinks');
    if (!hamburgerBtns.length || !navLinks) return;

    hamburgerBtns.forEach(btn => {
        btn.setAttribute('aria-expanded', 'false');
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const open = navLinks.classList.toggle('active');
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            btn.textContent = open ? '✕' : '☰';
        });
    });

    document.addEventListener('click', (e) => {
        if (navLinks.classList.contains('active') && !navLinks.contains(e.target) && !e.target.closest('.hamburger, #mobileHamburger')) {
            navLinks.classList.remove('active');
            hamburgerBtns.forEach(b => { b.textContent = '☰'; b.setAttribute('aria-expanded', 'false'); });
        }
    });

    navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('active');
            hamburgerBtns.forEach(b => { b.textContent = '☰'; b.setAttribute('aria-expanded', 'false'); });
        });
    });
}

/* ---------------------------------------------------------------------------
   3. HEADER SHADOW ON SCROLL
   --------------------------------------------------------------------------- */
function initHeaderScrollState() {
    const header = document.querySelector('header');
    if (!header) return;
    const apply = () => header.classList.toggle('is-scrolled', window.scrollY > 12);
    apply();
    window.addEventListener('scroll', apply, { passive: true });
}

/* ---------------------------------------------------------------------------
   4. SCROLL PROGRESS BAR
   --------------------------------------------------------------------------- */
function initScrollProgress() {
    if (LV_PREFERS_REDUCED_MOTION) return;
    const bar = document.createElement('div');
    bar.className = 'lv-progress';
    bar.setAttribute('aria-hidden', 'true');
    document.body.appendChild(bar);

    const update = () => {
        const doc = document.documentElement;
        const max = (doc.scrollHeight - doc.clientHeight) || 1;
        bar.style.width = Math.min(100, Math.max(0, (doc.scrollTop / max) * 100)) + '%';
    };
    update();
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
}

/* ---------------------------------------------------------------------------
   5. BACK TO TOP
   --------------------------------------------------------------------------- */
function initBackToTop() {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'lv-backtop';
    btn.setAttribute('aria-label', 'Back to top');
    btn.textContent = '↑';
    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: LV_PREFERS_REDUCED_MOTION ? 'auto' : 'smooth' });
    });
    document.body.appendChild(btn);

    const toggle = () => btn.classList.toggle('show', window.scrollY > 480);
    toggle();
    window.addEventListener('scroll', toggle, { passive: true });
}

/* ---------------------------------------------------------------------------
   6. SCROLL REVEAL (cards, headers, grids, tables)
   --------------------------------------------------------------------------- */
function initScrollReveal() {
    const selector = [
        '.card', '.member-card', '.stat-card', '.admin-card', '.cms-card',
        '.section-header', '.card-section', '.service-card', '.estimator-widget',
        '.estimate-result-box', '.login-card', '.req-item', '.footer-grid > *',
        '.grid > *', '.member-grid > *', '.stat-item'
    ].join(', ');

    const targets = Array.from(document.querySelectorAll(selector)).filter(el => {
        if (el.closest('.modal-overlay') || el.closest('.admin-table') || el.closest('.cms-table')) return false;
        return !el.classList.contains('lv-reveal');
    });

    if (!targets.length || !('IntersectionObserver' in window) || LV_PREFERS_REDUCED_MOTION) {
        targets.forEach(el => el.classList.add('lv-in'));
        return;
    }

    targets.forEach((el, index) => {
        el.classList.add('lv-reveal');
        // gentle stagger inside the same row / grid
        el.style.setProperty('--lv-delay', Math.min(index % 6, 5) * 70 + 'ms');
    });

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('lv-in');
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    targets.forEach(el => observer.observe(el));
}

/* ---------------------------------------------------------------------------
   7. ANIMATED STAT COUNTERS
   --------------------------------------------------------------------------- */
function initCounters() {
    const counters = document.querySelectorAll('.stat-value, .stat-num');
    if (!counters.length) return;

    const animate = (el) => {
        const raw = el.textContent.trim();
        const match = raw.match(/^(\D*)(\d+(?:[.,]\d+)?)(.*)$/);
        if (!match) return;
        const prefix = match[1], target = parseFloat(match[2].replace(',', '')), suffix = match[3];
        if (LV_PREFERS_REDUCED_MOTION || !isFinite(target)) return;

        const duration = 1100;
        const start = performance.now();
        const step = (now) => {
            const p = Math.min(1, (now - start) / duration);
            const eased = 1 - Math.pow(1 - p, 3);
            el.textContent = prefix + Math.round(target * eased) + suffix;
            if (p < 1) requestAnimationFrame(step);
            else el.textContent = raw;
        };
        requestAnimationFrame(step);
    };

    if (!('IntersectionObserver' in window)) { counters.forEach(animate); return; }
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) { animate(entry.target); obs.unobserve(entry.target); }
        });
    }, { threshold: 0.5 });
    counters.forEach(el => observer.observe(el));
}

/* ---------------------------------------------------------------------------
   8. PASSWORD FIELD: VISIBILITY TOGGLE + CAPS LOCK HINT
   --------------------------------------------------------------------------- */
function initPasswordToggles() {
    document.querySelectorAll('.password-field').forEach(field => {
        const input = field.querySelector('input');
        const toggle = field.querySelector('.password-toggle');
        const hint = field.querySelector('.caps-hint');
        if (!input) return;

        if (!toggle) {
            // create the toggle automatically for any password field
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'password-toggle';
            btn.textContent = 'Show';
            btn.setAttribute('aria-label', 'Show password');
            field.appendChild(btn);
        }

        const btn = field.querySelector('.password-toggle');
        btn.addEventListener('click', () => {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.textContent = show ? 'Hide' : 'Show';
            btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            input.focus();
        });

        if (hint) {
            const check = (event) => {
                const caps = event.getModifierState && event.getModifierState('CapsLock');
                hint.classList.toggle('show', !!caps);
            };
            input.addEventListener('keyup', check);
            input.addEventListener('keydown', check);
            input.addEventListener('blur', () => hint.classList.remove('show'));
        }
    });
}

/* ---------------------------------------------------------------------------
   9. MODAL ACCESSIBILITY + ANIMATION
   --------------------------------------------------------------------------- */
function initModalA11y() {
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) overlay.classList.remove('active');
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(modal => modal.classList.remove('active'));
        }
    });
}

/* ---------------------------------------------------------------------------
   10. SMOOTH ANCHOR NAVIGATION
   --------------------------------------------------------------------------- */
function initSmoothAnchors() {
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        const href = link.getAttribute('href');
        if (!href || href === '#' || link.hasAttribute('onclick')) return;
        link.addEventListener('click', (e) => {
            const target = document.querySelector(href);
            if (!target) return;
            e.preventDefault();
            target.scrollIntoView({ behavior: LV_PREFERS_REDUCED_MOTION ? 'auto' : 'smooth', block: 'start' });
        });
    });
}

/* ---------------------------------------------------------------------------
   11. MODAL OPEN / CLOSE HELPERS
   --------------------------------------------------------------------------- */
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add('active');
    const focusable = modal.querySelector('input:not([type="hidden"]), select, textarea, button');
    if (focusable) setTimeout(() => focusable.focus(), 120);
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.remove('active');
}

/* ---------------------------------------------------------------------------
   12. PROJECT COST & TIMELINE ESTIMATOR
   --------------------------------------------------------------------------- */
const EST_LABELS = {
    portal: 'Website & Web Application Portal',
    mobile: 'Mobile App Development (iOS & Android)',
    systems: 'Systems Integration & Re-Engineering',
    ai: 'AI & Cognitive Business Operations',
    amc: '24/7 AMC Support & Maintenance',
    mvp: 'Startup MVP / Fast Track',
    enterprise: 'Mid-Size Enterprise Scale',
    global: 'Global MNC Scale & High Concurrency',
    rush: 'Rush Delivery (1-2 Months)',
    standard: 'Standard Delivery (3-4 Months)',
    retainer: 'Long-term Partnership / Retainer'
};

let estState = {
    service: 'portal',
    scale: 'enterprise',
    timeline: 'standard'
};

/**
 * Maps either a canonical keyword ("portal") or a legacy descriptive label
 * ("Website & Web App Portal") from older markup/data onto a canonical keyword.
 */
const EST_ALIASES = [
    // service
    ['ai', /ai\b|cognitive|generative|llm|data science/i],
    ['amc', /amc|maintenance|support/i],
    ['mobile', /mobile|ios|android/i],
    ['systems', /systems|integration|re-engin|erp|legacy/i],
    ['portal', /portal|website|web app|web &|web and/i],
    // scale
    ['global', /global|mnc|high traffic|high concurrency/i],
    ['enterprise', /enterprise/i],
    ['mvp', /mvp|startup|fast track/i],
    // timeline
    ['rush', /rush|urgent|1-2|one to two/i],
    ['retainer', /retainer|long-term|long term|partnership/i],
    ['standard', /standard|3-4|three to four/i]
];

function estKey(value) {
    const v = String(value == null ? '' : value).trim();
    if (!v) return 'portal';
    const lower = v.toLowerCase();
    if (EST_LABELS[lower]) return lower;                 // exact canonical keyword
    for (const [key, pattern] of EST_ALIASES) {
        if (pattern.test(v)) return key;
    }
    return 'portal';
}

function selectEstOption(group, val, btn) {
    estState[group] = estKey(val);
    if (btn) {
        const parent = btn.parentElement;
        parent.querySelectorAll('.option-pill').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
    }
    calculateEstimate();
}

function calculateEstimate() {
    const costEl = document.getElementById('estCostDisplay');
    const timeEl = document.getElementById('estTimeDisplay');
    const descEl = document.getElementById('estDescDisplay');
    if (!costEl) return;

    const service = estKey(estState.service);
    const scale = estKey(estState.scale);
    const timeline = estKey(estState.timeline);

    let baseCost = 9000;   // in thousands (₹9L baseline)
    let timeWeeks = 12;

    if (service === 'mobile') { baseCost = 11000; timeWeeks = 14; }
    else if (service === 'ai') { baseCost = 12000; timeWeeks = 16; }
    else if (service === 'systems') { baseCost = 9000; timeWeeks = 10; }
    else if (service === 'amc') { baseCost = 5000; timeWeeks = 4; }

    if (scale === 'mvp') { baseCost *= 0.6; timeWeeks *= 0.7; }
    else if (scale === 'global') { baseCost *= 1.8; timeWeeks *= 1.4; }

    if (timeline === 'rush') { baseCost *= 1.25; timeWeeks *= 0.6; }
    else if (timeline === 'retainer') { baseCost *= 0.9; timeWeeks *= 1.2; }

    const minCost = Math.round((baseCost * 0.85) / 100);
    const maxCost = Math.round((baseCost * 1.15) / 100);
    const minTime = Math.max(1, Math.round((timeWeeks * 0.8) / 4));
    const maxTime = Math.max(2, Math.round((timeWeeks * 1.2) / 4));

    costEl.textContent = '₹' + minCost + 'L - ₹' + maxCost + 'L';
    if (timeEl) timeEl.textContent = minTime + ' - ' + maxTime + ' Months';
    if (descEl) {
        descEl.textContent = 'Estimated for: ' + EST_LABELS[service] + ' (' + EST_LABELS[scale] + ') — ' + EST_LABELS[timeline] + '.';
    }
}

function bookEstimateConsultation() {
    const costEl = document.getElementById('estCostDisplay');
    const estimate = costEl ? costEl.textContent : '—';
    const subject = encodeURIComponent('Consultation: ' + EST_LABELS[estKey(estState.service)]);
    const message = encodeURIComponent(
        'Hello LIVEpro Engineering Team,\n\n' +
        'I used the interactive estimator on your website and would like to schedule a technical consultation for:\n\n' +
        '• Service Type: ' + EST_LABELS[estKey(estState.service)] + '\n' +
        '• Project Scale: ' + EST_LABELS[estKey(estState.scale)] + '\n' +
        '• Desired Timeline: ' + EST_LABELS[estKey(estState.timeline)] + '\n' +
        '• Estimated Investment: ' + estimate + '\n\n' +
        'Please let me know when an engineering architect is available to discuss our project.'
    );
    window.location.href = 'contact.php?subject=' + subject + '&message=' + message;
}

/* ---------------------------------------------------------------------------
   13. LIVE INSTANT SEARCH & FILTERS
   --------------------------------------------------------------------------- */
function liveFilter(selector, query) {
    const q = String(query || '').toLowerCase().trim();
    document.querySelectorAll(selector).forEach(card => {
        const match = !q || card.textContent.toLowerCase().includes(q);
        card.style.display = match ? '' : 'none';
    });
}

function liveSearchProjects(query) { liveFilter('.project-card-item', query); }
function liveSearchCareers(query) { liveFilter('.career-card-item', query); }
function liveSearchExpertise(query) { liveFilter('.expertise-card-item', query); }

/* ---------------------------------------------------------------------------
   14. FAQ ACCORDION
   --------------------------------------------------------------------------- */
function toggleFaq(el) {
    const item = el.closest ? el.closest('.faq-item') : el;
    const target = item || el;
    const wasActive = target.classList.contains('active');
    const siblings = target.parentElement ? target.parentElement.querySelectorAll('.faq-item.active') : [];
    siblings.forEach(sib => sib.classList.remove('active'));
    if (!wasActive) target.classList.add('active');
}

/* ---------------------------------------------------------------------------
   15. SUBMIT BUTTON LOADING STATE (used by login + forms)
   --------------------------------------------------------------------------- */
function setButtonLoading(button, loading) {
    if (!button) return;
    if (loading) {
        button.dataset.label = button.innerHTML;
        button.classList.add('is-loading');
        button.innerHTML = '<span class="btn-spinner" aria-hidden="true"></span> Please wait';
        button.disabled = true;
    } else {
        button.classList.remove('is-loading');
        button.disabled = false;
        if (button.dataset.label) button.innerHTML = button.dataset.label;
    }
}
