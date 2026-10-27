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

// Hero artwork slider: advances on its own and pauses while hovered or focused. Each piece keeps
// its element and glides to its next slot (see .art-piece in app.css).
const artSlider = document.querySelector('[data-art-slider]');

if (artSlider) {
    const artPieces = Array.from(artSlider.querySelectorAll('[data-art-piece]'));
    const count = artPieces.length;
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let centre = 1;
    let artTimer;

    const slotFor = (offset) => {
        if (offset === -1) return 'left';
        if (offset === 0) return 'center';
        if (offset === 1) return 'right';
        return offset < 0 ? 'out-left' : 'out-right';
    };

    const arrange = () => {
        artPieces.forEach((piece, i) => {
            let offset = (((i - centre) % count) + count) % count;
            if (offset >= count / 2) offset -= count;

            const slot = slotFor(offset);
            const visible = slot === 'left' || slot === 'center' || slot === 'right';
            piece.dataset.slot = slot;
            piece.setAttribute('aria-hidden', visible ? 'false' : 'true');
            piece.setAttribute('tabindex', visible ? '0' : '-1');
        });
    };

    const stopArtTimer = () => window.clearInterval(artTimer);
    const startArtTimer = () => {
        stopArtTimer();
        if (!prefersReducedMotion) {
            artTimer = window.setInterval(() => {
                centre = (centre + 1) % count;
                arrange();
            }, 4800);
        }
    };

    const go = (step) => {
        centre = (centre + step + count) % count;
        arrange();
    };

    // Drag (mouse, pen or touch) to move the slider; a short drag steps one piece. A drag never
    // counts as a click, and clicking a side piece brings it to the centre.
    let dragStartX = null;
    let dragged = false;

    artSlider.addEventListener('pointerdown', (event) => {
        if (event.button !== undefined && event.button !== 0) return;
        dragStartX = event.clientX;
        dragged = false;
        stopArtTimer();
    });

    artSlider.addEventListener('pointermove', (event) => {
        if (dragStartX === null) return;
        if (Math.abs(event.clientX - dragStartX) > 8) {
            dragged = true;
            artSlider.classList.add('is-dragging');
        }
    });

    const endDrag = (event) => {
        if (dragStartX === null) return;
        const distance = event.clientX - dragStartX;
        dragStartX = null;
        artSlider.classList.remove('is-dragging');

        if (dragged && Math.abs(distance) > 40) {
            go(distance < 0 ? 1 : -1);
        }

        if (event.pointerType !== 'mouse') startArtTimer();
    };

    artSlider.addEventListener('pointerup', endDrag);
    artSlider.addEventListener('pointercancel', endDrag);
    artSlider.addEventListener('dragstart', (event) => event.preventDefault());

    artSlider.addEventListener('click', (event) => {
        const piece = event.target.closest('[data-art-piece]');

        if (dragged) {
            event.preventDefault();
            dragged = false;
            return;
        }

        if (piece && piece.dataset.slot === 'left') {
            event.preventDefault();
            go(-1);
        } else if (piece && piece.dataset.slot === 'right') {
            event.preventDefault();
            go(1);
        }
    }, true);

    // Letting go outside the slider ends the drag too.
    artSlider.addEventListener('pointerleave', (event) => {
        if (dragStartX !== null && event.pointerType === 'mouse') {
            dragStartX = null;
            artSlider.classList.remove('is-dragging');
        }
    });

    artSlider.addEventListener('mouseenter', stopArtTimer);
    artSlider.addEventListener('mouseleave', startArtTimer);
    artSlider.addEventListener('focusin', stopArtTimer);
    artSlider.addEventListener('focusout', startArtTimer);

    arrange();
    startArtTimer();
}
