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
