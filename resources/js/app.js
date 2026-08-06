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

// Count up [data-counter] numbers (hero stats strip) from 0 to their target once visible.
const animateCounter = (el) => {
    const target = parseFloat(el.dataset.value);
    const decimals = parseInt(el.dataset.decimals || '0', 10);
    const prefix = el.dataset.prefix || '';
    const suffix = el.dataset.suffix || '';
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
