document.addEventListener('DOMContentLoaded', () => {
    if (window.AOS) {
        window.AOS.init({ duration: 700, once: true, easing: 'ease-out-cubic' });
    }

    initPublicHeader();
    initPublicMenu();
    initThemeToggle();
    initToastAlerts();
    initMarketplaceFilters();
    initNotifications();
    initVoiceSearch();
    initAnimatedCounters();
    initAuctionCountdowns();
});

function initPublicHeader() {
    const header = document.querySelector('.public-site-header');

    if (!header) {
        return;
    }

    const syncHeader = () => {
        header.classList.toggle('is-scrolled', window.scrollY > 12);
    };

    syncHeader();
    window.addEventListener('scroll', syncHeader, { passive: true });
}

function initPublicMenu() {
    const headerInner = document.querySelector('.public-site-header__inner');
    const toggle = document.querySelector('.public-site-menu-toggle');

    if (!headerInner || !toggle) {
        return;
    }

    const closeMenu = () => {
        headerInner.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => {
        const isOpen = headerInner.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    headerInner.querySelectorAll('.public-site-menu a').forEach((link) => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 1199.98) {
                closeMenu();
            }
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 1199.98) {
            closeMenu();
        }
    });
}

function initThemeToggle() {
    const html = document.documentElement;
    const savedTheme = localStorage.getItem('agrovision-theme');
    if (savedTheme) {
        html.setAttribute('data-bs-theme', savedTheme);
    }

    const themeToggle = document.getElementById('themeToggle');
    if (!themeToggle) {
        return;
    }

    themeToggle.addEventListener('click', () => {
        const nextTheme = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-bs-theme', nextTheme);
        localStorage.setItem('agrovision-theme', nextTheme);
    });
}

function initToastAlerts() {
    const successAlert = document.querySelector('.alert-success');
    const errorAlert = document.querySelector('.alert-danger');

    if (window.Swal && successAlert) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: successAlert.textContent.trim(),
            showConfirmButton: false,
            timer: 2600,
        });
    }

    if (window.Swal && errorAlert && !successAlert) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: errorAlert.textContent.trim(),
            showConfirmButton: false,
            timer: 3400,
        });
    }
}

function initMarketplaceFilters() {
    const form = document.getElementById('marketplaceFilterForm');
    const grid = document.getElementById('marketplaceGrid');
    const pagination = document.getElementById('marketplacePagination');

    if (!form || !grid || typeof window.$ === 'undefined') {
        return;
    }

    const performRequest = () => {
        const skeletons = Array.from({ length: 6 })
            .map(() => '<div class="col-md-6 col-xl-4"><div class="skeleton"></div></div>')
            .join('');

        grid.innerHTML = skeletons;

        window.$.get(form.action, window.$(form).serialize(), (response) => {
            grid.innerHTML = response.html;

            if (pagination && response.pagination) {
                pagination.innerHTML = response.pagination;
            }

            if (window.AOS) {
                window.AOS.refreshHard();
            }
        });
    };

    window.$(form).on('change keyup', 'input, select', () => {
        clearTimeout(window.marketplaceTimer);
        window.marketplaceTimer = setTimeout(performRequest, 320);
    });
}

function initNotifications() {
    const list = document.getElementById('notificationList');
    const badge = document.getElementById('notificationCount');
    const markRead = document.getElementById('markNotificationsRead');
    const csrf = document.querySelector('meta[name="csrf-token"]');

    if (!list || !badge || !csrf) {
        return;
    }

    const refresh = async () => {
        const response = await fetch('/notifications/latest', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        if (!response.ok) {
            return;
        }

        const data = await response.json();
        badge.textContent = data.count;
        badge.classList.toggle('d-none', !data.count);

        if (!data.items.length) {
            list.innerHTML = '<div class="p-3 text-secondary">No new notifications yet.</div>';
            return;
        }

        list.innerHTML = data.items.map((item) => `
            <a class="notification-item" href="${item.action_url}">
                <div class="fw-semibold">${item.title}</div>
                <div class="small text-secondary">${item.message}</div>
                <div class="small text-success mt-1">${item.created_at}</div>
            </a>
        `).join('');
    };

    refresh();
    setInterval(refresh, 30000);

    if (!markRead) {
        return;
    }

    markRead.addEventListener('click', async () => {
        await fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf.content,
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        refresh();
    });
}

function initVoiceSearch() {
    const button = document.getElementById('voiceSearchButton');
    const input = document.getElementById('voiceSearchInput');

    if (!button || !input) {
        return;
    }

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (!SpeechRecognition) {
        button.disabled = true;
        button.title = 'Voice search is not supported in this browser.';
        return;
    }

    const recognition = new SpeechRecognition();
    recognition.lang = document.documentElement.lang === 'hi' ? 'hi-IN' : 'en-IN';
    recognition.interimResults = false;

    button.addEventListener('click', () => {
        recognition.start();
        button.classList.add('btn-success');
    });

    recognition.addEventListener('result', (event) => {
        const transcript = event.results[0][0].transcript;
        input.value = transcript;
        input.dispatchEvent(new Event('keyup'));
    });

    recognition.addEventListener('end', () => {
        button.classList.remove('btn-success');
    });
}

function initAnimatedCounters() {
    const counters = document.querySelectorAll('[data-countup]');

    if (!counters.length) {
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            const element = entry.target;
            const target = Number(element.dataset.countup);
            const formatter = element.dataset.countupFormat || 'number';
            animateCount(element, target, formatter);
            observer.unobserve(element);
        });
    }, { threshold: 0.3 });

    counters.forEach((counter) => observer.observe(counter));
}

function animateCount(element, target, formatter) {
    const duration = 1200;
    const start = performance.now();

    const frame = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        const value = target * easeOutCubic(progress);
        element.textContent = formatCount(value, formatter, progress === 1);

        if (progress < 1) {
            requestAnimationFrame(frame);
        }
    };

    requestAnimationFrame(frame);
}

function easeOutCubic(t) {
    return 1 - Math.pow(1 - t, 3);
}

function formatCount(value, formatter, isFinal) {
    if (formatter === 'currency') {
        return `INR ${Math.round(value).toLocaleString('en-IN')}`;
    }

    if (formatter === 'decimal') {
        return Number(value).toFixed(isFinal ? 1 : 0);
    }

    return Math.round(value).toLocaleString('en-IN');
}

function initAuctionCountdowns() {
    const timers = document.querySelectorAll('[data-countdown]');

    if (!timers.length) {
        return;
    }

    const render = () => {
        timers.forEach((timer) => {
            const endsAt = new Date(timer.dataset.countdown);
            const diff = endsAt.getTime() - Date.now();

            if (diff <= 0) {
                timer.textContent = 'Closed';
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff / (1000 * 60)) % 60);
            const seconds = Math.floor((diff / 1000) % 60);
            timer.textContent = `${hours}h ${minutes}m ${seconds}s`;
        });
    };

    render();
    setInterval(render, 1000);
}
