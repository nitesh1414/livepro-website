/**
 * LIVEpro Software Solutions x TCS Enterprise Theme
 * Client-Side JavaScript Logic & Interactivity (LP Geometric Logo Theme)
 */

document.addEventListener('DOMContentLoaded', () => {
    // Mobile Hamburger Menu Toggle & Responsive Navigation Handling
    const hamburgerBtns = document.querySelectorAll('.hamburger, #mobileHamburger');
    const navLinks = document.getElementById('navLinks');
    if (hamburgerBtns.length > 0 && navLinks) {
        hamburgerBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                navLinks.classList.toggle('active');
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (navLinks.classList.contains('active') && !navLinks.contains(e.target) && !e.target.closest('.hamburger, #mobileHamburger')) {
                navLinks.classList.remove('active');
            }
        });

        // Close mobile menu when any link inside is clicked
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
            });
        });
    }

    // Modal close on ESC key
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                modal.classList.remove('active');
            });
        }
    });

    // Modal close on outside click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
            }
        });
    });

    // Initialize Estimator Calculator if present
    if (document.getElementById('estimatorWidget')) {
        calculateEstimate();
    }
});

// Modal Open / Close Helpers
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.add('active');
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.remove('active');
}

/* ============================================================================
   1. INTERACTIVE PROJECT COST & TIMELINE ESTIMATOR CALCULATOR
   ============================================================================ */
let estState = {
    service: 'Website & Web App Portal',
    scale: 'Mid-Size Enterprise Scale',
    timeline: 'Standard Delivery (3-4 Months)'
};

function selectEstOption(group, val, btn) {
    estState[group] = val;
    // Update button active states in group
    const parent = btn.parentElement;
    parent.querySelectorAll('.option-pill').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    calculateEstimate();
}

function calculateEstimate() {
    const costEl = document.getElementById('estCostDisplay');
    const timeEl = document.getElementById('estTimeDisplay');
    const descEl = document.getElementById('estDescDisplay');
    if (!costEl) return;

    let baseCost = 800000; // 8L base
    let timeWeeks = 12;

    if (estState.service.includes('Mobile App')) { baseCost = 10000; timeWeeks = 14; }
    else if (estState.service.includes('AI & Cognitive')) { baseCost = 12000; timeWeeks = 16; }
    else if (estState.service.includes('Systems Integration')) { baseCost = 9000; timeWeeks = 10; }
    else if (estState.service.includes('24/7 AMC Support')) { baseCost = 5000; timeWeeks = 4; }

    if (estState.scale.includes('Startup MVP')) { baseCost *= 0.6; timeWeeks *= 0.7; }
    else if (estState.scale.includes('Global MNC Scale')) { baseCost *= 1.8; timeWeeks *= 1.4; }

    if (estState.timeline.includes('Rush Delivery')) { baseCost *= 1.25; timeWeeks *= 0.6; }
    else if (estState.timeline.includes('Long-term Partnership')) { baseCost *= 0.9; timeWeeks *= 1.2; }

    const minCost = Math.round(baseCost * 0.85 / 10000);
    const maxCost = Math.round(baseCost * 1.15 / 10000);
    const minTime = Math.round(timeWeeks * 0.8 / 4);
    const maxTime = Math.round(timeWeeks * 1.2 / 4);

    costEl.textContent = `₹${minCost}L - ₹${maxCost}L`;
    timeEl.textContent = `${Math.max(1, minTime)} - ${Math.max(2, maxTime)} Months`;
    descEl.textContent = `Estimated for: ${estState.service} (${estState.scale}) under ${estState.timeline}.`;
}

function bookEstimateConsultation() {
    const subject = encodeURIComponent(`Consultation: ${estState.service} (${estState.scale})`);
    const message = encodeURIComponent(`Hello LIVEpro Engineering Team,\n\nI used the interactive estimator on your website and would like to schedule a technical consultation for the following requirements:\n\n• Service Type: ${estState.service}\n• Project Scale: ${estState.scale}\n• Desired Timeline: ${estState.timeline}\n• Estimated Investment: ${document.getElementById('estCostDisplay').textContent}\n\nPlease let me know when an engineering architect is available to discuss our project.`);
    window.location.href = `contact.php?subject=${subject}&message=${message}`;
}

/* ============================================================================
   2. LIVE INSTANT SEARCH & FILTER
   ============================================================================ */
function liveSearchProjects(query) {
    const q = query.toLowerCase().trim();
    document.querySelectorAll('.project-card-item').forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(q) ? 'flex' : 'none';
    });
}

function liveSearchCareers(query) {
    const q = query.toLowerCase().trim();
    document.querySelectorAll('.career-card-item').forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(q) ? 'flex' : 'none';
    });
}

function liveSearchExpertise(query) {
    const q = query.toLowerCase().trim();
    document.querySelectorAll('.expertise-card-item').forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(q) ? 'flex' : 'none';
    });
}

/* ============================================================================
   3. INTERACTIVE FAQ ACCORDION
   ============================================================================ */
function toggleFaq(el) {
    el.classList.toggle('active');
}
