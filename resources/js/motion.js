// Motion for the storefront home page: word reveals, scroll depth, pointer tilt.
// Everything here is progressive: if this file fails or motion is reduced, the page stays fully readable.

const root = document.documentElement;
const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

const SELECTOR = '[data-split], [data-rise], [data-plate3d], [data-clip], [data-stagger]';

// Wrap each word in a mask so it can rise into place.
const splitWords = (el) => {
    const words = el.textContent.trim().replace(/\s+/g, ' ').split(' ');
    el.textContent = '';

    words.forEach((word, i) => {
        const mask = document.createElement('span');
        mask.className = 'split-w';
        const inner = document.createElement('span');
        inner.className = 'split-w__in';
        inner.style.setProperty('--w', i);
        inner.textContent = word;
        mask.appendChild(inner);
        el.appendChild(mask);

        if (i < words.length - 1) el.appendChild(document.createTextNode(' '));
    });

    el.classList.add('is-split');
};

const setup = () => {
    const items = Array.from(document.querySelectorAll(SELECTOR));
    if (!items.length) return;

    document.querySelectorAll('[data-stagger]').forEach((group) => {
        Array.from(group.children).forEach((child, i) => child.style.setProperty('--i', i));
    });

    if (reduced) {
        document.querySelectorAll('[data-split]').forEach((el) => el.classList.add('is-split'));
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    document.querySelectorAll('[data-split]').forEach(splitWords);

    const show = (el) => {
        el.classList.add('is-visible');
        // Once a staggered group has finished entering, hover effects should not inherit its delays.
        if (el.hasAttribute('data-stagger')) window.setTimeout(() => el.classList.add('is-settled'), 2600);
    };

    if (!('IntersectionObserver' in window)) {
        items.forEach(show);
        return;
    }

    let delivered = false;
    const pending = new Set(items);

    const observer = new IntersectionObserver((entries) => {
        delivered = true;
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            show(entry.target);
            pending.delete(entry.target);
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });

    items.forEach((el) => observer.observe(el));

    // Some embedded browsers never deliver observer callbacks. If none arrive, fall back to measuring on scroll.
    window.setTimeout(() => {
        if (delivered) return;

        const check = () => {
            const limit = window.innerHeight * 0.94;
            pending.forEach((el) => {
                if (el.getBoundingClientRect().top < limit) {
                    show(el);
                    pending.delete(el);
                }
            });
        };

        window.addEventListener('scroll', check, { passive: true });
        window.addEventListener('resize', check);
        check();
    }, 1000);
};

// Scroll: a hairline progress bar and layered depth on images.
const setupScroll = () => {
    const layers = Array.from(document.querySelectorAll('[data-parallax]'));
    const hero = document.querySelector('[data-hero]');
    let bar = null;

    if (hero) {
        bar = document.createElement('div');
        bar.className = 'scroll-progress';
        bar.setAttribute('aria-hidden', 'true');
        document.body.appendChild(bar);
    }

    if (!layers.length && !bar) return;

    let ticking = false;

    const update = () => {
        ticking = false;
        const vh = window.innerHeight;

        if (bar) {
            const max = document.documentElement.scrollHeight - vh;
            bar.style.transform = `scaleX(${max > 0 ? Math.min(window.scrollY / max, 1).toFixed(4) : 0})`;
        }

        layers.forEach((layer) => {
            const frame = layer.parentElement.getBoundingClientRect();
            if (frame.bottom < -200 || frame.top > vh + 200) return;

            const offset = frame.top + frame.height / 2 - vh / 2;
            layer.style.translate = `0 ${(-offset * parseFloat(layer.dataset.parallax)).toFixed(1)}px`;
        });
    };

    const request = () => {
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(update);
    };

    window.addEventListener('scroll', request, { passive: true });
    window.addEventListener('resize', request);
    update();
};

// Pointer: plates tilt in perspective with a soft light, buttons lean toward the cursor.
const setupPointer = () => {
    if (!finePointer) return;

    document.querySelectorAll('[data-tilt]').forEach((el) => {
        const max = parseFloat(el.dataset.tilt) || 6;
        const glare = document.createElement('span');
        glare.className = 'tilt-glare';
        glare.setAttribute('aria-hidden', 'true');
        el.appendChild(glare);

        let rx = 0;
        let ry = 0;
        let tx = 0;
        let ty = 0;
        let frame = null;
        let inside = false;

        const render = () => {
            rx += (tx - rx) * 0.12;
            ry += (ty - ry) * 0.12;
            el.style.transform = `perspective(1100px) rotateX(${rx.toFixed(2)}deg) rotateY(${ry.toFixed(2)}deg)`;

            if (inside || Math.abs(tx - rx) > 0.02 || Math.abs(ty - ry) > 0.02) {
                frame = window.requestAnimationFrame(render);
            } else {
                frame = null;
                el.style.transform = '';
            }
        };

        const run = () => {
            if (!frame) frame = window.requestAnimationFrame(render);
        };

        el.addEventListener('pointermove', (event) => {
            if (event.pointerType !== 'mouse') return;
            const box = el.getBoundingClientRect();
            const px = (event.clientX - box.left) / box.width;
            const py = (event.clientY - box.top) / box.height;

            ty = (px - 0.5) * 2 * max;
            tx = -(py - 0.5) * 2 * max;
            glare.style.setProperty('--gx', `${(px * 100).toFixed(1)}%`);
            glare.style.setProperty('--gy', `${(py * 100).toFixed(1)}%`);
            inside = true;
            run();
        });

        el.addEventListener('pointerleave', () => {
            inside = false;
            tx = 0;
            ty = 0;
            run();
        });
    });

    document.querySelectorAll('[data-magnetic]').forEach((el) => {
        el.addEventListener('pointermove', (event) => {
            const box = el.getBoundingClientRect();
            const dx = (event.clientX - (box.left + box.width / 2)) / box.width;
            const dy = (event.clientY - (box.top + box.height / 2)) / box.height;
            el.style.translate = `${(dx * 14).toFixed(1)}px ${(dy * 10).toFixed(1)}px`;
        });
        el.addEventListener('pointerleave', () => {
            el.style.translate = '';
        });
    });

    // A soft pool of light follows the cursor across the hero photograph.
    const hero = document.querySelector('[data-hero]');
    const glow = hero ? hero.querySelector('.hero-glow') : null;

    if (hero && glow) {
        let pending = false;
        let point = null;

        hero.addEventListener('pointermove', (event) => {
            const box = hero.getBoundingClientRect();
            point = [event.clientX - box.left, event.clientY - box.top];
            if (pending) return;
            pending = true;
            window.requestAnimationFrame(() => {
                pending = false;
                glow.style.setProperty('--mx', `${point[0]}px`);
                glow.style.setProperty('--my', `${point[1]}px`);
            });
        });
    }
};

try {
    setup();

    if (!reduced) {
        setupScroll();
        setupPointer();
    }
} catch (error) {
    // Never leave content hidden if something here breaks.
    root.classList.remove('js');
    console.error(error);
}
