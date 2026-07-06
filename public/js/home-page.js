document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const header = document.querySelector('[data-header]');
    const navToggle = document.querySelector('[data-nav-toggle]');
    const navPanel = document.querySelector('[data-nav-panel]');
    const navDropdowns = Array.from(document.querySelectorAll('[data-nav-dropdown]'));
    const menuLinks = Array.from(document.querySelectorAll('[data-nav-panel] a'));
    const navLinks = Array.from(document.querySelectorAll('[data-nav-link]'));
    const revealItems = Array.from(document.querySelectorAll('[data-reveal]'));
    const countItems = Array.from(document.querySelectorAll('[data-count]'));
    const sections = Array.from(document.querySelectorAll('[data-section]'));
    const parallaxStage = document.querySelector('[data-parallax]');
    const backToTop = document.querySelector('[data-backtotop]');
    const heroSlider = document.querySelector('[data-hero-slider]');
    const heroSlides = Array.from(document.querySelectorAll('[data-hero-slide]'));
    const heroDots = Array.from(document.querySelectorAll('[data-hero-dot]'));
    const heroPrev = document.querySelector('[data-hero-prev]');
    const heroNext = document.querySelector('[data-hero-next]');
    const aboutHeroSlider = document.querySelector('[data-about-hero-slider]');
    const aboutHeroSlides = Array.from(document.querySelectorAll('[data-about-hero-slide]'));
    const aboutHeroDots = Array.from(document.querySelectorAll('[data-about-hero-dot]'));
    const aboutHeroPrev = document.querySelector('[data-about-hero-prev]');
    const aboutHeroNext = document.querySelector('[data-about-hero-next]');

    const closeDropdowns = (activeDropdown = null) => {
        navDropdowns.forEach((dropdown) => {
            const isActive = activeDropdown instanceof HTMLElement && dropdown === activeDropdown;
            const toggle = dropdown.querySelector('[data-nav-dropdown-toggle]');

            dropdown.classList.toggle('is-open', isActive);

            if (toggle instanceof HTMLElement) {
                toggle.setAttribute('aria-expanded', isActive ? 'true' : 'false');
            }
        });
    };

    const setHeaderState = () => {
        if (!header) {
            return;
        }

        header.classList.toggle('is-scrolled', window.scrollY > 18);
    };

    const closeNav = () => {
        if (!navToggle || !navPanel) {
            return;
        }

        navToggle.setAttribute('aria-expanded', 'false');
        navPanel.classList.remove('is-open');
        body.classList.remove('nav-open');
        closeDropdowns();
    };

    const openNav = () => {
        if (!navToggle || !navPanel) {
            return;
        }

        navToggle.setAttribute('aria-expanded', 'true');
        navPanel.classList.add('is-open');
        body.classList.add('nav-open');
    };

    if (navToggle && navPanel) {
        navToggle.addEventListener('click', () => {
            const expanded = navToggle.getAttribute('aria-expanded') === 'true';

            if (expanded) {
                closeNav();
            } else {
                openNav();
            }
        });

        menuLinks.forEach((link) => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 1024) {
                    closeNav();
                }
            });
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) {
                closeNav();
            }
        });
    }

    if (navDropdowns.length) {
        navDropdowns.forEach((dropdown) => {
            const toggle = dropdown.querySelector('[data-nav-dropdown-toggle]');

            if (!(toggle instanceof HTMLElement)) {
                return;
            }

            toggle.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();

                const shouldOpen = !dropdown.classList.contains('is-open');
                closeDropdowns(shouldOpen ? dropdown : null);
            });
        });

        document.addEventListener('click', (event) => {
            if (!(event.target instanceof Element) || event.target.closest('[data-nav-dropdown]')) {
                return;
            }

            closeDropdowns();
        });
    }

    if (revealItems.length) {
        const revealObserver = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                });
            },
            {
                threshold: 0.16,
                rootMargin: '0px 0px -10% 0px',
            }
        );

        revealItems.forEach((item) => revealObserver.observe(item));
    }

    if (countItems.length) {
        const countObserver = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    const target = Number(entry.target.getAttribute('data-count'));
                    const duration = 1400;
                    const startTime = performance.now();

                    const step = (time) => {
                        const progress = Math.min((time - startTime) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        entry.target.textContent = Math.round(target * eased).toString();

                        if (progress < 1) {
                            requestAnimationFrame(step);
                        }
                    };

                    requestAnimationFrame(step);
                    observer.unobserve(entry.target);
                });
            },
            {
                threshold: 0.45,
            }
        );

        countItems.forEach((item) => countObserver.observe(item));
    }

    if (heroSlider && heroSlides.length > 1) {
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let activeSlide = Math.max(heroSlides.findIndex((slide) => slide.classList.contains('is-active')), 0);
        let heroTimer = null;

        const setHeroSlide = (nextIndex) => {
            const total = heroSlides.length;
            activeSlide = (nextIndex + total) % total;

            heroSlides.forEach((slide, index) => {
                const isActive = index === activeSlide;
                slide.classList.toggle('is-active', isActive);
                slide.setAttribute('aria-hidden', isActive ? 'false' : 'true');
            });

            heroDots.forEach((dot, index) => {
                const isActive = index === activeSlide;
                dot.classList.toggle('is-active', isActive);
                dot.setAttribute('aria-current', isActive ? 'true' : 'false');
            });
        };

        const stopHeroAutoplay = () => {
            if (!heroTimer) {
                return;
            }

            window.clearInterval(heroTimer);
            heroTimer = null;
        };

        const startHeroAutoplay = () => {
            if (reduceMotion) {
                return;
            }

            stopHeroAutoplay();
            heroTimer = window.setInterval(() => {
                setHeroSlide(activeSlide + 1);
            }, 3000);
        };

        if (heroPrev) {
            heroPrev.addEventListener('click', () => {
                setHeroSlide(activeSlide - 1);
                startHeroAutoplay();
            });
        }

        if (heroNext) {
            heroNext.addEventListener('click', () => {
                setHeroSlide(activeSlide + 1);
                startHeroAutoplay();
            });
        }

        heroDots.forEach((dot) => {
            dot.addEventListener('click', () => {
                const nextIndex = Number(dot.getAttribute('data-hero-index'));
                setHeroSlide(nextIndex);
                startHeroAutoplay();
            });
        });

        heroSlider.addEventListener('click', (event) => {
            const target = event.target;

            if (target instanceof Element && target.closest('a, button, form, input, textarea, select')) {
                return;
            }

            setHeroSlide(activeSlide + 1);
            startHeroAutoplay();
        });

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stopHeroAutoplay();
            } else {
                startHeroAutoplay();
            }
        });

        setHeroSlide(activeSlide);
        startHeroAutoplay();
    }

    if (aboutHeroSlider && aboutHeroSlides.length > 1) {
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let activeAboutSlide = Math.max(aboutHeroSlides.findIndex((slide) => slide.classList.contains('is-active')), 0);
        let aboutHeroTimer = null;

        const setAboutHeroSlide = (nextIndex) => {
            const total = aboutHeroSlides.length;
            activeAboutSlide = (nextIndex + total) % total;

            aboutHeroSlides.forEach((slide, index) => {
                const isActive = index === activeAboutSlide;
                slide.classList.toggle('is-active', isActive);
                slide.setAttribute('aria-hidden', isActive ? 'false' : 'true');
            });

            aboutHeroDots.forEach((dot, index) => {
                const isActive = index === activeAboutSlide;
                dot.classList.toggle('is-active', isActive);
                dot.setAttribute('aria-current', isActive ? 'true' : 'false');
            });
        };

        const stopAboutHeroAutoplay = () => {
            if (!aboutHeroTimer) {
                return;
            }

            window.clearInterval(aboutHeroTimer);
            aboutHeroTimer = null;
        };

        const startAboutHeroAutoplay = () => {
            if (reduceMotion) {
                return;
            }

            stopAboutHeroAutoplay();
            aboutHeroTimer = window.setInterval(() => {
                setAboutHeroSlide(activeAboutSlide + 1);
            }, 3000);
        };

        if (aboutHeroPrev) {
            aboutHeroPrev.addEventListener('click', () => {
                setAboutHeroSlide(activeAboutSlide - 1);
                startAboutHeroAutoplay();
            });
        }

        if (aboutHeroNext) {
            aboutHeroNext.addEventListener('click', () => {
                setAboutHeroSlide(activeAboutSlide + 1);
                startAboutHeroAutoplay();
            });
        }

        aboutHeroDots.forEach((dot) => {
            dot.addEventListener('click', () => {
                const nextIndex = Number(dot.getAttribute('data-about-hero-index'));
                setAboutHeroSlide(nextIndex);
                startAboutHeroAutoplay();
            });
        });

        aboutHeroSlider.addEventListener('click', (event) => {
            const target = event.target;

            if (target instanceof Element && target.closest('a, button, form, input, textarea, select')) {
                return;
            }

            setAboutHeroSlide(activeAboutSlide + 1);
            startAboutHeroAutoplay();
        });

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stopAboutHeroAutoplay();
            } else {
                startAboutHeroAutoplay();
            }
        });

        setAboutHeroSlide(activeAboutSlide);
        startAboutHeroAutoplay();
    }

    if (sections.length && navLinks.length) {
        const updateActiveLink = () => {
            const offset = window.innerHeight * 0.25;
            let activeId = 'home';

            sections.forEach((section) => {
                const top = section.getBoundingClientRect().top;

                if (top - offset <= 0) {
                    activeId = section.id;
                }
            });

            navLinks.forEach((link) => {
                const href = link.getAttribute('href');
                const isAnchor = href && href.startsWith('#');
                link.classList.toggle('is-active', isAnchor && href === `#${activeId}`);
            });
        };

        updateActiveLink();
        window.addEventListener('scroll', updateActiveLink, { passive: true });
    }

    if (parallaxStage && window.matchMedia('(prefers-reduced-motion: reduce)').matches === false) {
        const resetParallax = () => {
            parallaxStage.style.setProperty('--parallax-x', '0');
            parallaxStage.style.setProperty('--parallax-y', '0');
        };

        parallaxStage.addEventListener('pointermove', (event) => {
            const rect = parallaxStage.getBoundingClientRect();
            const x = (event.clientX - rect.left) / rect.width - 0.5;
            const y = (event.clientY - rect.top) / rect.height - 0.5;

            parallaxStage.style.setProperty('--parallax-x', (x * 5).toFixed(2));
            parallaxStage.style.setProperty('--parallax-y', (y * 4).toFixed(2));
        });

        parallaxStage.addEventListener('pointerleave', resetParallax);
    }

    setHeaderState();
    window.addEventListener('scroll', setHeaderState, { passive: true });

    if (backToTop) {
        const updateBackToTop = () => {
            backToTop.classList.toggle('is-visible', window.scrollY > 460);
        };

        updateBackToTop();
        window.addEventListener('scroll', updateBackToTop, { passive: true });
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeDropdowns();
            closeNav();
        }
    });
});
