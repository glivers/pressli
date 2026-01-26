/**
 * Aurora Theme - Main JavaScript
 * Version: 1.0
 */

(function() {
    'use strict';

    // Mobile Navigation Toggle (if needed in the future)
    function initMobileNav() {
        const navToggle = document.querySelector('.nav-toggle');
        const navigation = document.querySelector('.site-navigation');

        if (navToggle) {
            navToggle.addEventListener('click', function() {
                navigation.classList.toggle('active');
            });
        }
    }

    // Smooth Scroll for Anchor Links
    function initSmoothScroll() {
        const links = document.querySelectorAll('a[href^="#"]');

        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#') {
                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    }

    // Add active class to current menu item
    function initActiveMenuItem() {
        const currentPage = window.location.pathname.split('/').pop() || 'index.html';
        const menuLinks = document.querySelectorAll('.site-navigation a');

        menuLinks.forEach(link => {
            const linkPage = link.getAttribute('href');
            if (linkPage === currentPage) {
                link.classList.add('active');
            }
        });
    }

    // Initialize all functions when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initMobileNav();
        initSmoothScroll();
        initActiveMenuItem();

        console.log('Aurora Theme Loaded');
    });

})();
