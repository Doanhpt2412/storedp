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
