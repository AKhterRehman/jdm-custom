import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Reveal [data-reveal] elements with a fade+slide as they scroll into view.
if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('[data-reveal]').forEach((el) => observer.observe(el));
} else {
    document.querySelectorAll('[data-reveal]').forEach((el) => el.classList.add('is-visible'));
}

// Accessible hero slider: dots select a slide, autoplay pauses while hovered.
const heroSlider = document.querySelector('.hero-slider');
const heroDots = document.querySelectorAll('[data-hero-dots] .hero-dot');

if (heroSlider && heroDots.length) {
    const heroSlides = heroSlider.querySelectorAll('.hero-slide');
    let activeSlide = 0;
    let heroTimer;

    const showHeroSlide = (index) => {
        activeSlide = (index + heroSlides.length) % heroSlides.length;
        heroSlider.classList.add('is-manual');
        heroSlides.forEach((slide, slideIndex) => slide.classList.toggle('is-active', slideIndex === activeSlide));
        heroDots.forEach((dot, dotIndex) => {
            const isActive = dotIndex === activeSlide;
            dot.classList.toggle('is-active', isActive);
            dot.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });
    };

    const startHeroTimer = () => {
        window.clearInterval(heroTimer);
        heroTimer = window.setInterval(() => showHeroSlide(activeSlide + 1), 6000);
    };

    heroDots.forEach((dot) => dot.addEventListener('click', () => {
        showHeroSlide(Number(dot.dataset.slide));
        startHeroTimer();
    }));
    heroSlider.addEventListener('mouseenter', () => window.clearInterval(heroTimer));
    heroSlider.addEventListener('mouseleave', startHeroTimer);
    showHeroSlide(0);
    startHeroTimer();
}

// Count up [data-counter] numbers (hero stats strip) from 0 to their target once visible.
const animateCounter = (el) => {
    const target = parseFloat(el.dataset.value);
    const decimals = parseInt(el.dataset.decimals || '0', 10);
    const prefix = el.dataset.prefix || '';
    // Trim dataset values so encoded/trailing spaces never appear after % or +.
    const suffix = (el.dataset.suffix || '').trim();
    const duration = 1400;
    const start = performance.now();

    const tick = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const value = target * eased;
        el.textContent = `${prefix}${value.toFixed(decimals)}${suffix}`;
        if (progress < 1) {
            requestAnimationFrame(tick);
        }
    };

    requestAnimationFrame(tick);
};

if ('IntersectionObserver' in window) {
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.4 });

    document.querySelectorAll('[data-counter]').forEach((el) => counterObserver.observe(el));
} else {
    document.querySelectorAll('[data-counter]').forEach((el) => animateCounter(el));
}

// Some browser/layout combinations do not fire IntersectionObserver for the
// initially visible stats strip. Start those counters as a safe fallback.
window.setTimeout(() => {
    document.querySelectorAll('[data-counter]').forEach((el) => {
        if (/^0(?:\.0+)?(?:[^0-9]*)$/.test(el.textContent.trim())) animateCounter(el);
    });
}, 250);

// Home hero: pieces change when the progress line completes, and pause while the hero is hovered.
const heroSection = document.querySelector('[data-hero]');
const heroPieces = heroSection ? Array.from(heroSection.querySelectorAll('[data-hero-piece]')) : [];

if (heroPieces.length > 1) {
    const progress = heroSection.querySelector('.hero-progress');
    const bar = heroSection.querySelector('.hero-progress__bar');
    const nameEl = heroSection.querySelector('[data-hero-name]');
    const priceEl = heroSection.querySelector('[data-hero-price]');
    const countEl = heroSection.querySelector('[data-hero-count]');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let current = 0;

    const showPiece = (index) => {
        current = (index + heroPieces.length) % heroPieces.length;

        heroPieces.forEach((piece, i) => {
            const active = i === current;
            piece.classList.toggle('is-active', active);
            piece.setAttribute('tabindex', active ? '0' : '-1');
        });

        nameEl.textContent = heroPieces[current].dataset.name;
        priceEl.textContent = heroPieces[current].dataset.price;
        countEl.textContent = String(current + 1).padStart(2, '0');
    };

    const restartProgress = () => {
        progress.classList.remove('is-running');
        void progress.offsetWidth;
        progress.classList.add('is-running');
    };

    if (!reducedMotion) {
        bar.addEventListener('animationend', () => {
            showPiece(current + 1);
            restartProgress();
        });
        restartProgress();
    }
}

// Collection index: hovering or focusing a row brings that piece forward on the stage.
const indexSection = document.querySelector('[data-index]');

if (indexSection) {
    const rows = Array.from(indexSection.querySelectorAll('[data-index-row]'));
    const images = Array.from(indexSection.querySelectorAll('[data-index-image]'));
    const nameEl = indexSection.querySelector('[data-index-name]');
    const linkEl = indexSection.querySelector('[data-index-link]');

    const activate = (i) => {
        rows.forEach((row, n) => row.classList.toggle('is-active', n === i));
        images.forEach((image, n) => image.classList.toggle('is-active', n === i));

        if (images[i] && nameEl && linkEl) {
            nameEl.textContent = images[i].dataset.name;
            linkEl.setAttribute('href', images[i].dataset.url);
        }
    };

    rows.forEach((row, i) => {
        row.addEventListener('mouseenter', () => activate(i));
        row.addEventListener('focus', () => activate(i));
    });
}

// Theme switch: dark is the default, the choice is remembered on this device.
const themeButtons = document.querySelectorAll('[data-theme-toggle]');

const syncThemeButtons = () => {
    const light = document.documentElement.dataset.theme === 'light';
    themeButtons.forEach((button) => {
        button.setAttribute('aria-label', light ? 'Switch to the dark theme' : 'Switch to the light theme');
    });
};

themeButtons.forEach((button) => button.addEventListener('click', () => {
    const next = document.documentElement.dataset.theme === 'light' ? 'dark' : 'light';
    document.documentElement.dataset.theme = next;

    try {
        localStorage.setItem('jdm-theme', next);
    } catch (error) {
        // Private browsing can block storage; the theme still applies for this visit.
    }

    syncThemeButtons();
}));

syncThemeButtons();
