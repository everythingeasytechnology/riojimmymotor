/**
 * Auto Parts Marketplace Custom Javascript
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Sticky Header Shadow and Sizing on Scroll
    const header = document.querySelector('.sticky-header');
    if (header) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                header.classList.add('shadow-sm');
                header.style.padding = '5px 0';
            } else {
                header.classList.remove('shadow-sm');
                header.style.padding = '10px 0';
            }
        });
    }

    // 2. Mock Dynamic Vehicle Dropdowns Cascade
    const makeData = {
        '2024': ['Toyota', 'Honda', 'Ford', 'Chevrolet'],
        '2023': ['Toyota', 'Honda', 'Ford', 'Chevrolet', 'BMW', 'Audi'],
        '2022': ['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Nissan', 'Jeep'],
        '2021': ['Toyota', 'Honda', 'Ford', 'Dodge', 'Ram', 'Hyundai']
    };

    const modelData = {
        'Toyota': ['Camry', 'Corolla', 'RAV4', 'Tacoma', 'Tundra'],
        'Honda': ['Accord', 'Civic', 'CR-V', 'Pilot', 'Odyssey'],
        'Ford': ['F-150', 'Mustang', 'Explorer', 'Escape', 'Focus'],
        'Chevrolet': ['Silverado', 'Equinox', 'Malibu', 'Camaro', 'Tahoe'],
        'Nissan': ['Altima', 'Sentra', 'Rogue', 'Pathfinder'],
        'BMW': ['3 Series', '5 Series', 'X5', 'M4']
    };

    const yearSelect = document.getElementById('search-year');
    const makeSelect = document.getElementById('search-make');
    const modelSelect = document.getElementById('search-model');

    if (yearSelect && makeSelect && modelSelect) {
        yearSelect.addEventListener('change', function () {
            const year = this.value;
            makeSelect.innerHTML = '<option value="">Select Make</option>';
            modelSelect.innerHTML = '<option value="">Select Model</option>';
            modelSelect.disabled = true;

            if (year && makeData[year]) {
                makeSelect.disabled = false;
                makeData[year].forEach(function (make) {
                    const option = document.createElement('option');
                    option.value = make;
                    option.textContent = make;
                    makeSelect.appendChild(option);
                });
            } else {
                makeSelect.disabled = true;
            }
        });

        makeSelect.addEventListener('change', function () {
            const make = this.value;
            modelSelect.innerHTML = '<option value="">Select Model</option>';

            if (make && modelData[make]) {
                modelSelect.disabled = false;
                modelData[make].forEach(function (model) {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    modelSelect.appendChild(option);
                });
            } else {
                modelSelect.disabled = true;
            }
        });
    }

    // 3. Stats Counter Animation
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        const counters = document.querySelectorAll('.stat-number');
        let started = false;

        const startCounting = () => {
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const speed = 100; // lower number = faster
                const increment = Math.ceil(target / speed);
                
                let count = 0;
                const updateCount = () => {
                    count += increment;
                    if (count < target) {
                        counter.textContent = count + (counter.getAttribute('data-suffix') || '');
                        setTimeout(updateCount, 15);
                    } else {
                        counter.textContent = target.toLocaleString() + (counter.getAttribute('data-suffix') || '');
                    }
                };
                updateCount();
            });
        };

        const onScroll = () => {
            const sectionPos = statsSection.getBoundingClientRect().top;
            const screenPos = window.innerHeight;
            if (sectionPos < screenPos - 100 && !started) {
                started = true;
                startCounting();
                window.removeEventListener('scroll', onScroll);
            }
        };

        window.addEventListener('scroll', onScroll);
        // Trigger if already visible on load
        onScroll();
    }

    // 4. Product Gallery Thumbnail Switcher
    const mainImg = document.getElementById('main-gallery-img');
    const thumbs = document.querySelectorAll('.gallery-thumb-item');
    if (mainImg && thumbs.length > 0) {
        thumbs.forEach(thumb => {
            thumb.addEventListener('click', function () {
                thumbs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const newSrc = this.getAttribute('data-large');
                mainImg.setAttribute('src', newSrc);
            });
        });
    }

    // 5. Sidebar Filter Accordions for Mobile
    const filterHeaders = document.querySelectorAll('.filter-widget-title');
    filterHeaders.forEach(header => {
        header.addEventListener('click', function() {
            if (window.innerWidth < 768) {
                const list = this.nextElementSibling;
                if (list) {
                    if (list.style.display === 'none' || list.style.display === '') {
                        list.style.display = 'block';
                    } else {
                        list.style.display = 'none';
                    }
                }
            }
        });
    });

    // 6. Smooth scroll for Table of Contents
    const tocLinks = document.querySelectorAll('.toc-list a');
    tocLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const headerOffset = 90;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});
