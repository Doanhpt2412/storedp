document.documentElement.classList.add('js-ready');

const siteHeader = document.querySelector('[data-site-header]');
const scrollTopButton = document.querySelector('[data-scroll-top]');

if (siteHeader || scrollTopButton) {
    let lastKnownScrollY = window.scrollY;

    const syncScrollUi = () => {
        const isScrolled = lastKnownScrollY > 24;
        const showScrollTop = lastKnownScrollY > 360;

        siteHeader?.classList.toggle('is-scrolled', isScrolled);
        document.body.classList.toggle('has-scrolled-header', isScrolled);
        scrollTopButton?.classList.toggle('is-visible', showScrollTop);
    };

    syncScrollUi();

    window.addEventListener('scroll', () => {
        lastKnownScrollY = window.scrollY;
        window.requestAnimationFrame(syncScrollUi);
    }, { passive: true });

    scrollTopButton?.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
    });
}

const slider = document.querySelector('[data-slider]');

if (slider) {
    const slides = Array.from(slider.querySelectorAll('[data-slide]'));
    const dots = Array.from(slider.querySelectorAll('[data-slide-dot]'));
    let activeIndex = 0;
    let autoRotateTimer = null;

    const setActiveSlide = (index) => {
        if (!slides.length) {
            return;
        }

        const nextIndex = (index + slides.length) % slides.length;

        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle('is-active', slideIndex === nextIndex);
        });

        dots.forEach((dot, dotIndex) => {
            dot.classList.toggle('is-active', dotIndex === nextIndex);
        });

        activeIndex = nextIndex;
    };

    const stopAutoRotate = () => {
        if (autoRotateTimer) {
            window.clearInterval(autoRotateTimer);
            autoRotateTimer = null;
        }
    };

    const startAutoRotate = () => {
        if (slides.length < 2 || autoRotateTimer) {
            return;
        }

        autoRotateTimer = window.setInterval(() => {
            setActiveSlide(activeIndex + 1);
        }, 5600);
    };

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            setActiveSlide(index);
            stopAutoRotate();
            startAutoRotate();
        });
    });

    slider.addEventListener('mouseenter', stopAutoRotate);
    slider.addEventListener('mouseleave', startAutoRotate);
    slider.addEventListener('focusin', stopAutoRotate);
    slider.addEventListener('focusout', startAutoRotate);

    setActiveSlide(0);
    startAutoRotate();
}

const productGallery = document.querySelector('[data-product-gallery]');

if (productGallery) {
    const slides = Array.from(productGallery.querySelectorAll('[data-gallery-slide]'));
    const thumbs = Array.from(productGallery.querySelectorAll('[data-gallery-thumb]'));
    const thumbsTrack = productGallery.querySelector('[data-gallery-thumbs]');
    const prevButton = productGallery.querySelector('[data-gallery-prev]');
    const nextButton = productGallery.querySelector('[data-gallery-next]');
    const thumbPrevButton = productGallery.querySelector('[data-gallery-thumb-prev]');
    const thumbNextButton = productGallery.querySelector('[data-gallery-thumb-next]');
    let activeIndex = thumbs.findIndex((thumb) => thumb.classList.contains('is-active'));
    let thumbStartIndex = 0;

    if (activeIndex < 0) {
        activeIndex = 0;
    }

    const maxThumbsPerView = 4;

    const syncThumbViewport = () => {
        if (!thumbsTrack) {
            return;
        }

        const maxStart = Math.max(thumbs.length - maxThumbsPerView, 0);
        thumbStartIndex = Math.min(Math.max(thumbStartIndex, 0), maxStart);
        const firstThumb = thumbs[0];

        if (!firstThumb) {
            return;
        }

        const thumbWidth = firstThumb.getBoundingClientRect().width;
        const trackGap = 14;
        const offset = (thumbWidth + trackGap) * thumbStartIndex;
        thumbsTrack.style.transform = `translateX(-${offset}px)`;

        thumbPrevButton?.classList.toggle('is-disabled', thumbStartIndex === 0);
        thumbNextButton?.classList.toggle('is-disabled', thumbStartIndex >= maxStart);
    };

    const ensureThumbVisible = (index) => {
        if (index < thumbStartIndex) {
            thumbStartIndex = index;
        } else if (index >= thumbStartIndex + maxThumbsPerView) {
            thumbStartIndex = index - maxThumbsPerView + 1;
        }

        syncThumbViewport();
    };

    const setActiveSlide = (index) => {
        if (!slides.length || !thumbs.length) {
            return;
        }

        activeIndex = (index + slides.length) % slides.length;

        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle('is-active', slideIndex === activeIndex);
        });

        thumbs.forEach((thumb, thumbIndex) => {
            thumb.classList.toggle('is-active', thumbIndex === activeIndex);
        });

        ensureThumbVisible(activeIndex);
    };

    prevButton?.addEventListener('click', () => setActiveSlide(activeIndex - 1));
    nextButton?.addEventListener('click', () => setActiveSlide(activeIndex + 1));

    thumbPrevButton?.addEventListener('click', () => {
        thumbStartIndex -= 1;
        syncThumbViewport();
    });

    thumbNextButton?.addEventListener('click', () => {
        thumbStartIndex += 1;
        syncThumbViewport();
    });

    thumbs.forEach((thumb, index) => {
        thumb.addEventListener('click', () => {
            setActiveSlide(index);
        });
    });

    window.addEventListener('resize', syncThumbViewport);
    setActiveSlide(activeIndex);
}

const variantPickers = document.querySelectorAll('[data-variant-picker]');

variantPickers.forEach((picker) => {
    let variants = [];

    try {
        variants = JSON.parse(picker.getAttribute('data-variants') || '[]');
    } catch (error) {
        variants = [];
    }

    if (variants.length === 0) {
        return;
    }

    const priceEl = picker.querySelector('[data-variant-price]');
    const oldPriceEl = picker.querySelector('[data-variant-old-price]');
    const discountEl = picker.querySelector('[data-variant-discount]');
    const skuEl = picker.querySelector('[data-variant-sku]');
    const statusEl = picker.querySelector('[data-variant-status]');
    const selectedStorageEl = picker.querySelector('[data-selected-storage]');
    const selectedColorEl = picker.querySelector('[data-selected-color]');
    const cartForms = picker.querySelectorAll('[data-cart-form], [data-cart-form-buy-now]');
    const storageButtons = picker.querySelectorAll('[data-storage-option]');
    const colorButtons = picker.querySelectorAll('[data-color-option]');

    let selectedVariant = variants.find((variant) => variant.active) || variants[0];

    const setButtonState = (buttons, attribute, activeValue) => {
        buttons.forEach((button) => {
            const isActive = button.getAttribute(attribute) === activeValue;
            button.classList.toggle('border-red-500', isActive);
            button.classList.toggle('bg-red-50', isActive);
            button.classList.toggle('border-gray-200', !isActive);
            button.classList.toggle('hover:border-red-400', !isActive);

            button.querySelectorAll('strong, span').forEach((item) => {
                if (item.hasAttribute('data-active-check')) {
                    return;
                }

                item.classList.toggle('text-red-600', isActive);
                item.classList.toggle('text-gray-800', !isActive && item.tagName === 'STRONG');
                item.classList.toggle('text-gray-500', !isActive && item.tagName !== 'STRONG');
            });

            const check = button.querySelector('[data-active-check]');
            if (check) {
                check.classList.toggle('hidden', !isActive);
            }
        });
    };

    const renderVariant = (variant) => {
        selectedVariant = variant;

        if (priceEl) priceEl.textContent = variant.price || '';
        if (oldPriceEl) {
            oldPriceEl.textContent = variant.old_price || '';
            oldPriceEl.classList.toggle('hidden', !variant.old_price);
        }
        if (discountEl) {
            discountEl.textContent = variant.discount || '';
            discountEl.classList.toggle('hidden', !variant.discount);
        }
        if (skuEl) skuEl.textContent = variant.sku || 'N/A';
        if (statusEl) {
            statusEl.textContent = variant.status || 'Liên hệ';
            statusEl.classList.toggle('bg-green-100', Number(variant.stock || 0) > 0);
            statusEl.classList.toggle('text-green-700', Number(variant.stock || 0) > 0);
            statusEl.classList.toggle('bg-amber-100', Number(variant.stock || 0) <= 0);
            statusEl.classList.toggle('text-amber-700', Number(variant.stock || 0) <= 0);
        }
        if (selectedStorageEl) selectedStorageEl.textContent = variant.storage || '';
        if (selectedColorEl) selectedColorEl.textContent = variant.color || '';

        cartForms.forEach((cartForm) => {
            const skuInput = cartForm.querySelector('[data-cart-sku]');
            const storageInput = cartForm.querySelector('[data-cart-storage]');
            const colorInput = cartForm.querySelector('[data-cart-color]');
            const priceInput = cartForm.querySelector('[data-cart-price]');
            const oldPriceInput = cartForm.querySelector('[data-cart-old-price]');
            const discountInput = cartForm.querySelector('[data-cart-discount]');
            const priceValueInput = cartForm.querySelector('[data-cart-price-value]');

            if (skuInput) skuInput.value = variant.sku || '';
            if (storageInput) storageInput.value = variant.storage || '';
            if (colorInput) colorInput.value = variant.color || '';
            if (priceInput) priceInput.value = variant.price || '';
            if (oldPriceInput) oldPriceInput.value = variant.old_price || '';
            if (discountInput) discountInput.value = variant.discount || '';
            if (priceValueInput) {
                const numericPrice = Number(String(variant.price || '').replace(/[^\d]/g, ''));
                priceValueInput.value = Number.isNaN(numericPrice) ? 0 : numericPrice;
            }
        });

        setButtonState(storageButtons, 'data-storage-option', variant.storage || '');
        setButtonState(colorButtons, 'data-color-option', variant.color || '');
    };

    const findVariant = ({ storage, color }) => {
        return variants.find((variant) => variant.storage === storage && variant.color === color)
            || variants.find((variant) => storage && variant.storage === storage)
            || variants.find((variant) => color && variant.color === color)
            || selectedVariant;
    };

    storageButtons.forEach((button) => {
        button.addEventListener('click', () => {
            renderVariant(findVariant({
                storage: button.getAttribute('data-storage-option'),
                color: selectedVariant.color,
            }));
        });
    });

    colorButtons.forEach((button) => {
        button.addEventListener('click', () => {
            renderVariant(findVariant({
                storage: selectedVariant.storage,
                color: button.getAttribute('data-color-option'),
            }));
        });
    });

    renderVariant(selectedVariant);
});

// Modal Logic
const modalOpens = document.querySelectorAll('[data-modal-open]');
const modalCloses = document.querySelectorAll('[data-modal-close]');

modalOpens.forEach(btn => {
    btn.addEventListener('click', () => {
        const modalId = btn.getAttribute('data-modal-open');
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('is-open');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }
    });
});

modalCloses.forEach(btn => {
    btn.addEventListener('click', (e) => {
        const modal = btn.closest('.modal');
        if (modal) {
            modal.classList.remove('is-open');
            document.body.style.overflow = '';
        }
    });
});

const descriptionShell = document.querySelector('[data-description-shell]');
const descriptionToggle = document.querySelector('[data-description-toggle]');

if (descriptionShell && descriptionToggle) {
    const expandLabel = descriptionToggle.querySelector('[data-expand-label]');
    const collapseLabel = descriptionToggle.querySelector('[data-collapse-label]');

    descriptionToggle.addEventListener('click', () => {
        const isExpanded = descriptionShell.classList.toggle('is-expanded');

        expandLabel?.classList.toggle('hidden', isExpanded);
        collapseLabel?.classList.toggle('hidden', !isExpanded);
    });
}

// ==========================================
// TOAST SYSTEM & AJAX CART FUNCTIONALITY
// ==========================================

const toastContainer = document.getElementById('toast-container');

// Global showToast function
window.showToast = function ({ type = 'success', title = '', message = '', product = null, duration = 4000 }) {
    if (!toastContainer) return;

    const toast = document.createElement('div');
    toast.className = `toast-item toast-item--${type}`;
    
    // Status titles in Vietnamese
    const defaultTitle = type === 'success' ? 'Thành công!' : type === 'error' ? 'Lỗi hệ thống' : 'Thông tin';
    const displayTitle = title || defaultTitle;

    // SVG icons based on type
    let iconSvg = '';
    if (type === 'success') {
        iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>`;
    } else if (type === 'error') {
        iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`;
    } else {
        iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>`;
    }

    // HTML Content for the Toast
    let productHtml = '';
    if (product) {
        const metaInfo = [product.storage, product.color].filter(Boolean).join(' | ');
        productHtml = `
            <div class="toast-product">
                ${product.image ? `<img src="${product.image}" class="toast-product-img" alt="${product.name}">` : ''}
                <div class="toast-product-info">
                    <span class="toast-product-name">${product.name}</span>
                    ${metaInfo ? `<span class="toast-product-meta">${metaInfo}</span>` : ''}
                    <span class="toast-product-price">${product.price}</span>
                </div>
            </div>
        `;
    }

    // Action button for successful cart add
    let actionsHtml = '';
    if (type === 'success' && product) {
        actionsHtml = `
            <div class="toast-actions">
                <a href="/gio-hang" class="toast-btn-primary">Xem giỏ hàng</a>
                <button class="toast-btn-secondary" onclick="this.closest('.toast-item').querySelector('.toast-close').click()">Đóng</button>
            </div>
        `;
    }

    toast.innerHTML = `
        <div class="toast-icon">
            ${iconSvg}
        </div>
        <div class="toast-content">
            <h4 class="toast-title">${displayTitle}</h4>
            <p class="toast-message">${message}</p>
            ${productHtml}
            ${actionsHtml}
        </div>
        <button class="toast-close" aria-label="Đóng">&times;</button>
        <div class="toast-progress" style="animation-duration: ${duration}ms"></div>
    `;

    toastContainer.appendChild(toast);

    // Trigger enter animation
    setTimeout(() => {
        toast.classList.add('is-show');
    }, 10);

    // Auto close timer
    const autoCloseTimer = setTimeout(() => {
        closeToast(toast);
    }, duration);

    // Close button click
    toast.querySelector('.toast-close').addEventListener('click', () => {
        clearTimeout(autoCloseTimer);
        closeToast(toast);
    });
};

function closeToast(toast) {
    toast.classList.remove('is-show');
    toast.classList.add('is-hide');
    
    // Smooth height collapse
    toast.addEventListener('transitionend', (e) => {
        if (e.propertyName === 'transform') {
            toast.style.height = '0px';
            toast.style.padding = '0px';
            toast.style.marginTop = '0px';
            toast.style.border = 'none';
            toast.style.overflow = 'hidden';
            
            setTimeout(() => {
                toast.remove();
            }, 300);
        }
    });
}

// Automatically detect flash messages rendered in layout on DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    const flashMessages = document.querySelectorAll('[data-flash-message]');
    flashMessages.forEach(el => {
        const type = el.getAttribute('data-type') || 'success';
        const message = el.getAttribute('data-message') || '';
        if (message) {
            window.showToast({ type, message });
        }
    });
});

// Intercept form submissions for adding to cart
document.addEventListener('submit', async (e) => {
    const form = e.target.closest('[data-cart-form]');
    if (!form) return;

    // Prevent normal submit
    e.preventDefault();

    const submitBtn = form.querySelector('[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.7';
    }

    try {
        const formData = new FormData(form);
        const actionUrl = form.getAttribute('action');

        const response = await fetch(actionUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok && data.success) {
            // Update the cart count badge
            const badge = document.getElementById('cart-count-badge');
            if (badge) {
                badge.textContent = data.cart_count;
                // Trigger pulse animation
                badge.classList.remove('badge-pulse');
                void badge.offsetWidth; // Trigger reflow
                badge.classList.add('badge-pulse');
            }

            // Show Toast
            window.showToast({
                type: 'success',
                title: 'Đã thêm vào giỏ hàng!',
                message: data.message,
                product: data.product
            });
        } else {
            window.showToast({
                type: 'error',
                title: 'Thêm thất bại',
                message: data.message || 'Có lỗi xảy ra, vui lòng thử lại sau.'
            });
        }
    } catch (err) {
        console.error('Add to cart error:', err);
        window.showToast({
            type: 'error',
            title: 'Lỗi kết nối',
            message: 'Không thể kết nối đến máy chủ. Vui lòng kiểm tra lại mạng.'
        });
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '';
        }
    }
});

// ==========================================
// CART PAGE AUTO-UPDATE & INTERACTIVE LOGIC
// ==========================================

// Helper to get CSRF token
const getCsrfToken = () => {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
};

// Update picker button disabled states
const updatePickerButtonsState = (lineId, quantity) => {
    const minusBtn = document.querySelector(`[data-qty-btn="minus"][data-line-id="${lineId}"]`);
    const plusBtn = document.querySelector(`[data-qty-btn="plus"][data-line-id="${lineId}"]`);
    
    if (minusBtn) {
        if (quantity <= 1) {
            minusBtn.disabled = true;
            minusBtn.style.opacity = '0.3';
            minusBtn.style.cursor = 'not-allowed';
        } else {
            minusBtn.disabled = false;
            minusBtn.style.opacity = '';
            minusBtn.style.cursor = '';
        }
    }
    
    if (plusBtn) {
        if (quantity >= 99) {
            plusBtn.disabled = true;
            plusBtn.style.opacity = '0.3';
            plusBtn.style.cursor = 'not-allowed';
        } else {
            plusBtn.disabled = false;
            plusBtn.style.opacity = '';
            plusBtn.style.cursor = '';
        }
    }
};

// Initial run to set button states on page load
document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('[data-qty-input]');
    inputs.forEach(input => {
        const lineId = input.getAttribute('data-qty-input');
        const quantity = parseInt(input.value) || 1;
        updatePickerButtonsState(lineId, quantity);
    });
});

// Update cart quantity via AJAX
const legacyUpdateCartQuantity = async (lineId, newQuantity) => {
    const input = document.querySelector(`[data-qty-input="${lineId}"]`);
    const article = document.querySelector(`[data-cart-item="${lineId}"]`);
    
    if (!input || !article) return;

    // Show row loading state
    article.style.opacity = '0.6';
    updatePickerButtonsState(lineId, newQuantity);

    try {
        const response = await fetch(`/gio-hang/${lineId}`, {
            method: 'PATCH',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ quantity: newQuantity })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            // Update quantity input
            input.value = data.item_quantity;
            
            // Update row item subtotal with flash effect
            const itemSubtotalEl = document.querySelector(`[data-item-subtotal="${lineId}"]`);
            if (itemSubtotalEl) {
                itemSubtotalEl.textContent = data.formatted_item_subtotal;
                itemSubtotalEl.classList.remove('price-updated-flash');
                void itemSubtotalEl.offsetWidth; // trigger reflow
                itemSubtotalEl.classList.add('price-updated-flash');
            }

            // Update cart subtotal & summaries
            const subtotalEl = document.getElementById('cart-subtotal');
            if (subtotalEl) {
                subtotalEl.textContent = data.formatted_cart_subtotal;
                subtotalEl.classList.remove('price-updated-flash');
                void subtotalEl.offsetWidth;
                subtotalEl.classList.add('price-updated-flash');
            }

            // Update cart counts
            const totalCountEl = document.getElementById('cart-total-count');
            if (totalCountEl) totalCountEl.textContent = data.cart_count;

            const summaryCountEl = document.getElementById('cart-summary-count');
            if (summaryCountEl) summaryCountEl.textContent = data.cart_count;

            const badge = document.getElementById('cart-count-badge');
            if (badge) {
                badge.textContent = data.cart_count;
                badge.classList.remove('badge-pulse');
                void badge.offsetWidth;
                badge.classList.add('badge-pulse');
            }

            // Update button disabled states
            updatePickerButtonsState(lineId, data.item_quantity);

        } else {
            // Revert changes on failure
            window.showToast({
                type: 'error',
                title: 'Cập nhật thất bại',
                message: data.message || 'Không thể cập nhật số lượng.'
            });
        }
    } catch (err) {
        console.error('Update quantity error:', err);
        window.showToast({
            type: 'error',
            title: 'Lỗi kết nối',
            message: 'Không thể kết nối đến máy chủ.'
        });
    } finally {
        article.style.opacity = '';
    }
};

const cartQuantityState = new Map();

const getCartQuantityState = (lineId) => {
    if (!cartQuantityState.has(lineId)) {
        const input = document.querySelector(`[data-qty-input="${lineId}"]`);
        const initialQuantity = parseInt(input?.value || '1', 10) || 1;

        cartQuantityState.set(lineId, {
            serverQuantity: initialQuantity,
            desiredQuantity: initialQuantity,
            inFlight: false,
        });
    }

    return cartQuantityState.get(lineId);
};

const syncCartSummaryUi = (data) => {
    const subtotalEl = document.getElementById('cart-subtotal');
    if (subtotalEl) {
        subtotalEl.textContent = data.formatted_cart_subtotal;
        subtotalEl.classList.remove('price-updated-flash');
        void subtotalEl.offsetWidth;
        subtotalEl.classList.add('price-updated-flash');
    }

    const totalCountEl = document.getElementById('cart-total-count');
    if (totalCountEl) totalCountEl.textContent = data.cart_count;

    const summaryCountEl = document.getElementById('cart-summary-count');
    if (summaryCountEl) summaryCountEl.textContent = data.cart_count;

    const badge = document.getElementById('cart-count-badge');
    if (badge) {
        badge.textContent = data.cart_count;
        badge.classList.remove('badge-pulse');
        void badge.offsetWidth;
        badge.classList.add('badge-pulse');
    }
};

const sendCartQuantityUpdate = async (lineId) => {
    const input = document.querySelector(`[data-qty-input="${lineId}"]`);
    const article = document.querySelector(`[data-cart-item="${lineId}"]`);
    const state = getCartQuantityState(lineId);

    if (!input || !article || state.inFlight) return;

    const newQuantity = state.desiredQuantity;
    state.inFlight = true;
    article.style.opacity = '0.6';
    updatePickerButtonsState(lineId, newQuantity);

    try {
        const response = await fetch(`/gio-hang/${lineId}`, {
            method: 'PATCH',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ quantity: newQuantity })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            state.serverQuantity = data.item_quantity;
            input.value = data.item_quantity;

            const itemSubtotalEl = document.querySelector(`[data-item-subtotal="${lineId}"]`);
            if (itemSubtotalEl) {
                itemSubtotalEl.textContent = data.formatted_item_subtotal;
                itemSubtotalEl.classList.remove('price-updated-flash');
                void itemSubtotalEl.offsetWidth;
                itemSubtotalEl.classList.add('price-updated-flash');
            }

            syncCartSummaryUi(data);
            updatePickerButtonsState(lineId, data.item_quantity);
        } else {
            state.desiredQuantity = state.serverQuantity;
            input.value = state.serverQuantity;
            updatePickerButtonsState(lineId, state.serverQuantity);
            window.showToast({
                type: 'error',
                title: 'Cập nhật thất bại',
                message: data.message || 'Không thể cập nhật số lượng.'
            });
        }
    } catch (err) {
        console.error('Update quantity error:', err);
        state.desiredQuantity = state.serverQuantity;
        input.value = state.serverQuantity;
        updatePickerButtonsState(lineId, state.serverQuantity);
        window.showToast({
            type: 'error',
            title: 'Lỗi kết nối',
            message: 'Không thể kết nối đến máy chủ.'
        });
    } finally {
        state.inFlight = false;
        article.style.opacity = '';

        if (state.desiredQuantity !== state.serverQuantity) {
            input.value = state.desiredQuantity;
            updatePickerButtonsState(lineId, state.desiredQuantity);
            sendCartQuantityUpdate(lineId);
        }
    }
};

const updateCartQuantity = (lineId, newQuantity) => {
    const input = document.querySelector(`[data-qty-input="${lineId}"]`);
    if (!input) return;

    const state = getCartQuantityState(lineId);
    state.desiredQuantity = Math.min(99, Math.max(1, newQuantity));

    input.value = state.desiredQuantity;
    updatePickerButtonsState(lineId, state.desiredQuantity);

    if (!state.inFlight) {
        sendCartQuantityUpdate(lineId);
    }
};

// Delete cart item via AJAX
const deleteCartItem = async (lineId) => {
    const article = document.querySelector(`[data-cart-item="${lineId}"]`);
    if (!article) return;

    if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
        return;
    }

    article.style.opacity = '0.5';

    try {
        const response = await fetch(`/gio-hang/${lineId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            }
        });

        const data = await response.json();

        if (response.ok && data.success) {
            // Trigger beautiful fade-out and slide animation
            article.classList.add('cart-item-fade-out');
            
            setTimeout(() => {
                article.remove();
                
                // Update cart subtotal & summaries
                const subtotalEl = document.getElementById('cart-subtotal');
                if (subtotalEl) subtotalEl.textContent = data.formatted_cart_subtotal;

                const totalCountEl = document.getElementById('cart-total-count');
                if (totalCountEl) totalCountEl.textContent = data.cart_count;

                const summaryCountEl = document.getElementById('cart-summary-count');
                if (summaryCountEl) summaryCountEl.textContent = data.cart_count;

                const badge = document.getElementById('cart-count-badge');
                if (badge) {
                    badge.textContent = data.cart_count;
                    badge.classList.remove('badge-pulse');
                    void badge.offsetWidth;
                    badge.classList.add('badge-pulse');
                }

                // If cart is empty, show empty state
                if (data.cart_count === 0) {
                    const contentWrapper = document.getElementById('cart-content-wrapper');
                    const emptyState = document.getElementById('cart-empty-state');
                    if (contentWrapper) contentWrapper.classList.add('hidden');
                    if (emptyState) emptyState.classList.remove('hidden');
                }
            }, 450);

            window.showToast({
                type: 'success',
                title: 'Đã xóa sản phẩm',
                message: 'Sản phẩm đã được xóa khỏi giỏ hàng thành công.'
            });

        } else {
            article.style.opacity = '';
            window.showToast({
                type: 'error',
                title: 'Xóa thất bại',
                message: data.message || 'Không thể xóa sản phẩm.'
            });
        }
    } catch (err) {
        console.error('Delete item error:', err);
        article.style.opacity = '';
        window.showToast({
            type: 'error',
            title: 'Lỗi kết nối',
            message: 'Không thể kết nối đến máy chủ.'
        });
    }
};

// Event delegation for Quantity Picker and Delete Buttons
document.addEventListener('click', (e) => {
    // Quantity Picker: Plus Button
    const plusBtn = e.target.closest('[data-qty-btn="plus"]');
    if (plusBtn) {
        const lineId = plusBtn.getAttribute('data-line-id');
        const input = document.querySelector(`[data-qty-input="${lineId}"]`);
        if (input) {
            const currentVal = parseInt(input.value) || 1;
            if (currentVal < 99) {
                updateCartQuantity(lineId, currentVal + 1);
            }
        }
        return;
    }

    // Quantity Picker: Minus Button
    const minusBtn = e.target.closest('[data-qty-btn="minus"]');
    if (minusBtn) {
        const lineId = minusBtn.getAttribute('data-line-id');
        const input = document.querySelector(`[data-qty-input="${lineId}"]`);
        if (input) {
            const currentVal = parseInt(input.value) || 1;
            if (currentVal > 1) {
                updateCartQuantity(lineId, currentVal - 1);
            }
        }
        return;
    }

    // Cart Row Delete Button
    const deleteBtn = e.target.closest('[data-cart-delete-btn]');
    if (deleteBtn) {
        const lineId = deleteBtn.getAttribute('data-cart-delete-btn');
        deleteCartItem(lineId);
    }
});
