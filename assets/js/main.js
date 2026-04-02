/**
 * ShopCo Theme - Main JavaScript
 *
 * Handles: Mobile menu, search toggle, banner dismiss,
 * testimonial slider, shop filters, product gallery,
 * product tabs, cart quantity controls
 */

(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        initBanner();
        initMobileMenu();
        initMobileSearch();
        initTestimonialSlider();
        initStickyHeader();
        initShopFilters();
        initProductGallery();
        initProductTabs();
        initCartQuantity();
        initColorSizeSelectors();
        initFilterToggles();
        initPriceRangeSlider();
    });

    // ================================
    // Top Banner - Dismiss
    // ================================
    function initBanner() {
        var banner = document.getElementById('topBanner');
        var closeBtn = document.getElementById('closeBanner');
        if (!banner || !closeBtn) return;

        if (sessionStorage.getItem('shopco_banner_closed') === '1') {
            banner.classList.add('hidden');
            return;
        }

        closeBtn.addEventListener('click', function () {
            banner.classList.add('hidden');
            sessionStorage.setItem('shopco_banner_closed', '1');
        });
    }

    // ================================
    // Mobile Menu
    // ================================
    function initMobileMenu() {
        var toggle = document.getElementById('menuToggle');
        var nav = document.getElementById('mobileNav');
        var overlay = document.getElementById('mobileNavOverlay');
        var closeBtn = document.getElementById('mobileNavClose');
        if (!toggle || !nav) return;

        function openMenu() {
            nav.classList.add('active');
            if (overlay) overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            nav.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        toggle.addEventListener('click', openMenu);
        if (closeBtn) closeBtn.addEventListener('click', closeMenu);
        if (overlay) overlay.addEventListener('click', closeMenu);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && nav.classList.contains('active')) closeMenu();
        });
    }

    // ================================
    // Mobile Search Toggle
    // ================================
    function initMobileSearch() {
        var searchToggle = document.getElementById('searchToggle');
        var mobileSearch = document.getElementById('mobileSearch');
        if (!searchToggle || !mobileSearch) return;

        searchToggle.addEventListener('click', function () {
            mobileSearch.classList.toggle('active');
            if (mobileSearch.classList.contains('active')) {
                var input = mobileSearch.querySelector('input');
                if (input) input.focus();
            }
        });
    }

    // ================================
    // Testimonial Slider
    // ================================
    function initTestimonialSlider() {
        var slider = document.getElementById('testimonialSlider');
        var track = slider ? slider.querySelector('.testimonials__track') : null;
        var prevBtn = document.getElementById('testimonialPrev');
        var nextBtn = document.getElementById('testimonialNext');
        if (!slider || !track) return;

        var cards = track.querySelectorAll('.testimonial-card');
        if (cards.length === 0) return;

        var currentIndex = 0;
        var cardWidth = 0;
        var gap = 20;
        var visibleCards = 3;

        function calculateDimensions() {
            var sliderWidth = slider.offsetWidth;
            if (window.innerWidth <= 768) visibleCards = 1;
            else if (window.innerWidth <= 1024) visibleCards = 2;
            else visibleCards = 3;
            cardWidth = (sliderWidth - gap * (visibleCards - 1)) / visibleCards;
            cards.forEach(function (card) { card.style.minWidth = cardWidth + 'px'; });
        }

        function slideToIndex(index) {
            var maxIndex = Math.max(0, cards.length - visibleCards);
            currentIndex = Math.max(0, Math.min(index, maxIndex));
            track.style.transform = 'translateX(-' + (currentIndex * (cardWidth + gap)) + 'px)';
        }

        if (prevBtn) prevBtn.addEventListener('click', function () { slideToIndex(currentIndex - 1); });
        if (nextBtn) nextBtn.addEventListener('click', function () { slideToIndex(currentIndex + 1); });

        // Touch/swipe
        var touchStartX = 0;
        track.addEventListener('touchstart', function (e) { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
        track.addEventListener('touchend', function (e) {
            var diff = touchStartX - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 50) slideToIndex(currentIndex + (diff > 0 ? 1 : -1));
        }, { passive: true });

        calculateDimensions();
        window.addEventListener('resize', function () { calculateDimensions(); slideToIndex(currentIndex); });
    }

    // ================================
    // Sticky Header
    // ================================
    function initStickyHeader() {
        var header = document.getElementById('siteHeader');
        if (!header) return;
        window.addEventListener('scroll', function () {
            header.style.boxShadow = (window.pageYOffset > 10) ? '0 2px 8px rgba(0,0,0,0.08)' : 'none';
        }, { passive: true });
    }

    // ================================
    // Shop Filters (Mobile Drawer)
    // ================================
    function initShopFilters() {
        var filters = document.getElementById('shopFilters');
        var overlay = document.getElementById('filtersOverlay');
        var mobileToggle = document.getElementById('filtersMobileToggle');
        var closeBtn = document.getElementById('filtersClose');
        if (!filters) return;

        function openFilters() {
            filters.classList.add('shop-filters--open');
            if (overlay) overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeFilters() {
            filters.classList.remove('shop-filters--open');
            if (overlay) overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (mobileToggle) mobileToggle.addEventListener('click', openFilters);
        if (closeBtn) closeBtn.addEventListener('click', closeFilters);
        if (overlay) overlay.addEventListener('click', closeFilters);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && filters.classList.contains('shop-filters--open')) closeFilters();
        });
    }

    // ================================
    // Filter Group Toggles (Accordion)
    // ================================
    function initFilterToggles() {
        var toggles = document.querySelectorAll('.filter-group__toggle');
        toggles.forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                var group = this.closest('.filter-group');
                group.classList.toggle('filter-group--open');
            });
        });
    }

    // ================================
    // Price Range Slider
    // ================================
    function initPriceRangeSlider() {
        var minInput = document.getElementById('priceMin');
        var maxInput = document.getElementById('priceMax');
        var minVal = document.getElementById('priceMinVal');
        var maxVal = document.getElementById('priceMaxVal');
        var fill = document.getElementById('priceRangeFill');
        if (!minInput || !maxInput) return;

        function updateSlider() {
            var min = parseInt(minInput.value);
            var max = parseInt(maxInput.value);
            if (min > max) { var temp = min; min = max; max = temp; }
            if (minVal) minVal.textContent = min;
            if (maxVal) maxVal.textContent = max;
            if (fill) {
                var range = parseInt(minInput.max) - parseInt(minInput.min);
                var left = ((min - parseInt(minInput.min)) / range) * 100;
                var right = ((max - parseInt(minInput.min)) / range) * 100;
                fill.style.left = left + '%';
                fill.style.width = (right - left) + '%';
            }
        }

        minInput.addEventListener('input', updateSlider);
        maxInput.addEventListener('input', updateSlider);
        updateSlider();
    }

    // ================================
    // Product Gallery (Thumbnail Switch)
    // ================================
    function initProductGallery() {
        // Support both old and new class names
        var thumbs = document.querySelectorAll('.sp-gallery__thumb, .product-gallery__thumb');
        var mainImg = document.getElementById('spMainImage') || document.getElementById('productMainImage');
        if (!mainImg || thumbs.length === 0) return;

        thumbs.forEach(function (thumb) {
            thumb.addEventListener('click', function () {
                thumbs.forEach(function (t) {
                    t.classList.remove('sp-gallery__thumb--active');
                    t.classList.remove('product-gallery__thumb--active');
                });
                this.classList.add('sp-gallery__thumb--active');
                this.classList.add('product-gallery__thumb--active');
                mainImg.src = this.getAttribute('data-full');
            });
        });
    }

    // ================================
    // Product Tabs
    // ================================
    function initProductTabs() {
        // Support both old (product-tabs__tab) and new (sp-tabs__btn) class names
        var tabs = document.querySelectorAll('.sp-tabs__btn, .product-tabs__tab');
        if (tabs.length === 0) return;

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var tabId = this.getAttribute('data-tab');

                tabs.forEach(function (t) {
                    t.classList.remove('sp-tabs__btn--active');
                    t.classList.remove('product-tabs__tab--active');
                });
                this.classList.add('sp-tabs__btn--active');
                this.classList.add('product-tabs__tab--active');

                // Hide all panels
                document.querySelectorAll('.sp-tabs__panel, .product-tabs__panel').forEach(function (panel) {
                    panel.style.display = 'none';
                    panel.classList.remove('sp-tabs__panel--active');
                    panel.classList.remove('product-tabs__panel--active');
                });
                // Show selected - try both ID formats
                var target = document.getElementById('sp-tab-' + tabId) || document.getElementById('tab-' + tabId);
                if (target) {
                    target.style.display = 'block';
                    target.classList.add('sp-tabs__panel--active');
                }
            });
        });
    }

    // ================================
    // Cart Quantity +/- Buttons
    // ================================
    function initCartQuantity() {
        document.querySelectorAll('.cart-item__quantity').forEach(function (wrapper) {
            var minusBtn = wrapper.querySelector('.qty-minus');
            var plusBtn = wrapper.querySelector('.qty-plus');
            var input = wrapper.querySelector('input.qty');
            if (!minusBtn || !plusBtn || !input) return;

            minusBtn.addEventListener('click', function () {
                var val = parseInt(input.value) || 1;
                if (val > 1) {
                    input.value = val - 1;
                    // Trigger WooCommerce cart update
                    var updateBtn = document.querySelector('button[name="update_cart"]');
                    if (updateBtn) {
                        updateBtn.disabled = false;
                        updateBtn.click();
                    }
                }
            });

            plusBtn.addEventListener('click', function () {
                var val = parseInt(input.value) || 1;
                var max = parseInt(input.getAttribute('max'));
                if (!max || val < max) {
                    input.value = val + 1;
                    var updateBtn = document.querySelector('button[name="update_cart"]');
                    if (updateBtn) {
                        updateBtn.disabled = false;
                        updateBtn.click();
                    }
                }
            });
        });
    }

    // ================================
    // Color & Size Selectors (Single Product)
    // ================================
    function initColorSizeSelectors() {
        // Colors (both old and new classes)
        document.querySelectorAll('.sp-color input, .product-color-swatch input').forEach(function (input) {
            input.addEventListener('change', function () {
                var parent = this.closest('.sp-colors') || this.closest('.product-details__colors');
                if (parent) {
                    parent.querySelectorAll('.sp-color, .product-color-swatch').forEach(function (s) {
                        s.classList.remove('sp-color--active');
                        s.classList.remove('product-color-swatch--active');
                    });
                }
                var swatch = this.closest('.sp-color') || this.closest('.product-color-swatch');
                if (swatch) {
                    swatch.classList.add('sp-color--active');
                    swatch.classList.add('product-color-swatch--active');
                }
            });
        });

        // Sizes (both old and new classes)
        document.querySelectorAll('.sp-size input, .product-size-btn input').forEach(function (input) {
            input.addEventListener('change', function () {
                var parent = this.closest('.sp-sizes') || this.closest('.product-details__sizes');
                if (parent) {
                    parent.querySelectorAll('.sp-size, .product-size-btn').forEach(function (s) {
                        s.classList.remove('sp-size--active');
                        s.classList.remove('product-size-btn--active');
                    });
                }
                var btn = this.closest('.sp-size') || this.closest('.product-size-btn');
                if (btn) {
                    btn.classList.add('sp-size--active');
                    btn.classList.add('product-size-btn--active');
                }
            });
        });

        // Filter color swatches
        document.querySelectorAll('.color-swatch input').forEach(function (input) {
            input.addEventListener('change', function () {
                document.querySelectorAll('.color-swatch').forEach(function (s) {
                    s.classList.remove('color-swatch--active');
                });
                this.closest('.color-swatch').classList.add('color-swatch--active');
            });
        });

        // Filter size options
        document.querySelectorAll('.size-option input').forEach(function (input) {
            input.addEventListener('change', function () {
                document.querySelectorAll('.size-option').forEach(function (s) {
                    s.classList.remove('size-option--active');
                });
                this.closest('.size-option').classList.add('size-option--active');
            });
        });
    }

})();
