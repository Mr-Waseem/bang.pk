(function () {
    'use strict';

    function animateCounter(el) {
        if (el.dataset.animated === '1') return;
        el.dataset.animated = '1';
        const target = parseFloat(el.getAttribute('data-target')) || 0;
        const suffix = el.getAttribute('data-suffix') || '';
        const decimals = parseInt(el.getAttribute('data-decimals') || '0', 10);
        const duration = 1400;
        const startTime = performance.now();

        function tick(now) {
            const progress = Math.min((now - startTime) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = target * eased;
            el.textContent = (decimals ? current.toFixed(decimals) : Math.floor(current)) + suffix;
            if (progress < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    var trustBar = document.querySelector('.trust-bar');
    if (trustBar) {
        var trustObserver = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    trustBar.querySelectorAll('.trust-metric-value[data-target]').forEach(animateCounter);
                    obs.disconnect();
                }
            });
        }, { threshold: 0.2 });
        trustObserver.observe(trustBar);
    }

    document.querySelectorAll('.faq-question').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('.faq-item');
            var wasOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(function (i) { i.classList.remove('open'); });
            if (!wasOpen) item.classList.add('open');
        });
    });

    (function initVideoCarousel() {
        var carousel = document.querySelector('[data-video-carousel]');
        if (!carousel) return;

        var track = carousel.querySelector('.videos-carousel-track');
        var slides = Array.from(track.querySelectorAll('.video-item'));
        var prevBtn = carousel.querySelector('[data-video-prev]');
        var nextBtn = carousel.querySelector('[data-video-next]');
        var dotsWrap = carousel.querySelector('[data-video-dots]');
        var index = 0;
        var autoTimer = null;

        function getPerView() { return window.innerWidth <= 992 ? 1 : 2; }

        function loadIframe(slide) {
            var iframe = slide.querySelector('iframe[data-src]');
            if (iframe && !iframe.getAttribute('src')) {
                iframe.setAttribute('src', iframe.getAttribute('data-src'));
            }
        }

        function unloadIframe(slide) {
            var iframe = slide.querySelector('iframe[data-src]');
            if (iframe) iframe.removeAttribute('src');
        }

        function syncIframes() {
            var perView = getPerView();
            var start = index * perView;
            slides.forEach(unloadIframe);
            slides.slice(start, start + perView).forEach(loadIframe);
        }

        function buildDots() {
            if (!dotsWrap) return;
            dotsWrap.innerHTML = '';
            var pages = Math.ceil(slides.length / getPerView());
            for (var i = 0; i < pages; i++) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'videos-carousel-dot' + (i === index ? ' active' : '');
                dot.setAttribute('aria-label', 'Video page ' + (i + 1));
                dot.addEventListener('click', function (j) { return function () { goTo(j); }; }(i));
                dotsWrap.appendChild(dot);
            }
        }

        function updateDots() {
            if (!dotsWrap) return;
            dotsWrap.querySelectorAll('.videos-carousel-dot').forEach(function (d, i) {
                d.classList.toggle('active', i === index);
            });
        }

        function goTo(i) {
            var perView = getPerView();
            var pages = Math.ceil(slides.length / perView);
            index = ((i % pages) + pages) % pages;
            var targetSlide = slides[index * perView];
            track.style.transform = 'translateX(-' + (targetSlide ? targetSlide.offsetLeft : 0) + 'px)';
            updateDots();
            syncIframes();
        }

        function startAuto() {
            clearInterval(autoTimer);
            autoTimer = setInterval(function () { goTo(index + 1); }, 6000);
        }

        prevBtn && prevBtn.addEventListener('click', function () { goTo(index - 1); startAuto(); });
        nextBtn && nextBtn.addEventListener('click', function () { goTo(index + 1); startAuto(); });
        carousel.addEventListener('mouseenter', function () { clearInterval(autoTimer); });
        carousel.addEventListener('mouseleave', startAuto);
        window.addEventListener('resize', function () { buildDots(); goTo(Math.min(index, Math.ceil(slides.length / getPerView()) - 1)); });

        buildDots();
        goTo(0);
        startAuto();
    })();

    document.querySelectorAll('.feature-card').forEach(function (card, i) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.45s ease ' + (i * 0.05) + 's, transform 0.45s ease ' + (i * 0.05) + 's';
    });

    var featObs = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.feature-card').forEach(function (c) { featObs.observe(c); });
})();
