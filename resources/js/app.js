document.documentElement.classList.add('js-ready');

const slider = document.querySelector('[data-slider]');

if (slider) {
    const slides = slider.querySelectorAll('[data-slide]');
    const dots = slider.querySelectorAll('[data-slide-dot]');
    let activeIndex = 0;

    const setActiveSlide = (index) => {
        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle('is-active', slideIndex === index);
        });

        dots.forEach((dot, dotIndex) => {
            dot.classList.toggle('is-active', dotIndex === index);
        });

        activeIndex = index;
    };

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            setActiveSlide(index);
        });
    });

    window.setInterval(() => {
        const nextIndex = (activeIndex + 1) % slides.length;
        setActiveSlide(nextIndex);
    }, 5000);
}

const galleryMain = document.querySelector('[data-gallery-main]');
const galleryThumbs = document.querySelectorAll('[data-gallery-thumb]');

if (galleryMain && galleryThumbs.length > 0) {
    galleryThumbs.forEach((thumb) => {
        thumb.addEventListener('click', () => {
            const nextImage = thumb.getAttribute('data-image');

            if (!nextImage) {
                return;
            }

            galleryMain.setAttribute('src', nextImage);

            galleryThumbs.forEach((item) => {
                item.classList.remove('is-active');
            });

            thumb.classList.add('is-active');
        });
    });
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
