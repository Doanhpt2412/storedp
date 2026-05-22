<x-layouts.admin title="Slide & Banner">
    @php
        $slides = old('hero_slides', $slides ?? []);
        $banners = old('home_banners', $banners ?? []);
        $categoryBanners = old('category_banners', $categoryBanners ?? []);
    @endphp

    @if (session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <div class="font-semibold">Vui lòng kiểm tra lại dữ liệu nhập.</div>
            <ul class="mt-2 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Slide & Banner hiển thị</h1>
        <p class="mt-1 text-sm text-slate-500">Quản lý 3 slide trang chủ, 2 banner nhỏ ở home và 2 banner cho trang danh mục sản phẩm.</p>
    </div>

    <form method="POST" action="{{ route('admin.homepage.display.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <section class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Slide hero trang chủ</h2>
                    <p class="mt-1 text-xs text-slate-500">Mỗi slide có nội dung, nút bấm và ảnh riêng.</p>
                </div>
                <button type="button" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50" data-add-slide>Thêm slide</button>
            </div>

            <div class="space-y-4" data-slide-rows>
                @foreach ($slides as $index => $slide)
                    <div class="rounded-xl border border-slate-200 p-4" data-slide-row>
                        <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                            <strong class="text-sm text-slate-800" data-slide-title>Slide {{ $loop->iteration }}</strong>
                            <button type="button" class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50" data-remove-slide>Xóa</button>
                        </div>
                        <div class="grid grid-cols-1 gap-5 xl:grid-cols-[1.35fr_0.85fr]">
                            <div class="space-y-4">
                                <input type="text" name="hero_slides[{{ $index }}][eyebrow]" value="{{ $slide['eyebrow'] ?? '' }}" placeholder="Nhãn nhỏ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-slide-field="eyebrow">
                                <textarea name="hero_slides[{{ $index }}][title]" rows="3" placeholder="Tiêu đề" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-slide-field="title">{{ $slide['title'] ?? '' }}</textarea>
                                <textarea name="hero_slides[{{ $index }}][description]" rows="4" placeholder="Mô tả" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-slide-field="description">{{ $slide['description'] ?? '' }}</textarea>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <input type="text" name="hero_slides[{{ $index }}][primary_label]" value="{{ $slide['primary_label'] ?? '' }}" placeholder="Nút chính" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-slide-field="primary_label">
                                    <input type="text" name="hero_slides[{{ $index }}][primary_url]" value="{{ $slide['primary_url'] ?? '' }}" placeholder="Link nút chính" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-slide-field="primary_url">
                                </div>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <input type="text" name="hero_slides[{{ $index }}][secondary_label]" value="{{ $slide['secondary_label'] ?? '' }}" placeholder="Nút phụ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-slide-field="secondary_label">
                                    <input type="text" name="hero_slides[{{ $index }}][secondary_url]" value="{{ $slide['secondary_url'] ?? '' }}" placeholder="Link nút phụ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-slide-field="secondary_url">
                                </div>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <input type="text" name="hero_slides[{{ $index }}][highlight_label]" value="{{ $slide['highlight_label'] ?? '' }}" placeholder="Nhãn thông tin" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-slide-field="highlight_label">
                                    <input type="text" name="hero_slides[{{ $index }}][highlight_text]" value="{{ $slide['highlight_text'] ?? '' }}" placeholder="Nội dung thông tin" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-slide-field="highlight_text">
                                </div>
                                <input type="text" name="hero_slides[{{ $index }}][card_title]" value="{{ $slide['card_title'] ?? '' }}" placeholder="Tiêu đề thẻ phụ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-slide-field="card_title">
                                <textarea name="hero_slides[{{ $index }}][card_text]" rows="3" placeholder="Mô tả thẻ phụ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-slide-field="card_text">{{ $slide['card_text'] ?? '' }}</textarea>
                            </div>
                            <div class="space-y-4">
                                <input type="hidden" name="hero_slides[{{ $index }}][image_url]" value="{{ $slide['image_url'] ?? '' }}" data-slide-field="image_url">
                                <input type="file" name="hero_slides[{{ $index }}][image_file]" accept="image/*" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:font-semibold file:text-blue-700" data-slide-file="image_file">
                                <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                    @if (!empty($slide['image_url']))
                                        <img src="{{ $slide['image_url'] }}" alt="Slide preview" class="h-52 w-full object-cover">
                                    @else
                                        <div class="flex h-52 items-center justify-center bg-slate-100 text-sm font-medium text-slate-400">Chưa có ảnh nền</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Banner nhỏ trang chủ</h2>
                    <p class="mt-1 text-xs text-slate-500">2 banner hiển thị dưới khu vực hero.</p>
                </div>
                <button type="button" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50" data-add-banner="home">Thêm banner</button>
            </div>

            <div class="space-y-4" data-banner-rows="home">
                @foreach ($banners as $index => $banner)
                    <div class="rounded-xl border border-slate-200 p-4" data-banner-row>
                        <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                            <strong class="text-sm text-slate-800" data-banner-title>Banner {{ $loop->iteration }}</strong>
                            <button type="button" class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50" data-remove-banner>Xóa</button>
                        </div>
                        <div class="grid grid-cols-1 gap-5 xl:grid-cols-[1.2fr_0.8fr]">
                            <div class="space-y-4">
                                <input type="text" name="home_banners[{{ $index }}][eyebrow]" value="{{ $banner['eyebrow'] ?? '' }}" placeholder="Nhãn nhỏ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-banner-field="eyebrow">
                                <textarea name="home_banners[{{ $index }}][title]" rows="3" placeholder="Tiêu đề banner" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-banner-field="title">{{ $banner['title'] ?? '' }}</textarea>
                                <input type="text" name="home_banners[{{ $index }}][url]" value="{{ $banner['url'] ?? '' }}" placeholder="Link banner" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-banner-field="url">
                            </div>
                            <div class="space-y-4">
                                <input type="hidden" name="home_banners[{{ $index }}][image_url]" value="{{ $banner['image_url'] ?? '' }}" data-banner-field="image_url">
                                <input type="file" name="home_banners[{{ $index }}][image_file]" accept="image/*" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:font-semibold file:text-blue-700" data-banner-file="image_file">
                                <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                    @if (!empty($banner['image_url']))
                                        <img src="{{ $banner['image_url'] }}" alt="Banner preview" class="h-40 w-full object-cover">
                                    @else
                                        <div class="flex h-40 items-center justify-center bg-slate-100 text-sm font-medium text-slate-400">Chưa có ảnh nền</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Banner trang danh mục sản phẩm</h2>
                    <p class="mt-1 text-xs text-slate-500">2 banner hiển thị đầu trang danh mục.</p>
                </div>
                <button type="button" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50" data-add-banner="category">Thêm banner</button>
            </div>

            <div class="space-y-4" data-banner-rows="category">
                @foreach ($categoryBanners as $index => $banner)
                    <div class="rounded-xl border border-slate-200 p-4" data-banner-row>
                        <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                            <strong class="text-sm text-slate-800" data-banner-title>Banner {{ $loop->iteration }}</strong>
                            <button type="button" class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50" data-remove-banner>Xóa</button>
                        </div>
                        <div class="grid grid-cols-1 gap-5 xl:grid-cols-[1.2fr_0.8fr]">
                            <div class="space-y-4">
                                <input type="text" name="category_banners[{{ $index }}][eyebrow]" value="{{ $banner['eyebrow'] ?? '' }}" placeholder="Nhãn nhỏ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-banner-field="eyebrow">
                                <textarea name="category_banners[{{ $index }}][title]" rows="3" placeholder="Tiêu đề banner" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-banner-field="title">{{ $banner['title'] ?? '' }}</textarea>
                                <input type="text" name="category_banners[{{ $index }}][url]" value="{{ $banner['url'] ?? '' }}" placeholder="Link banner" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm" data-banner-field="url">
                            </div>
                            <div class="space-y-4">
                                <input type="hidden" name="category_banners[{{ $index }}][image_url]" value="{{ $banner['image_url'] ?? '' }}" data-banner-field="image_url">
                                <input type="file" name="category_banners[{{ $index }}][image_file]" accept="image/*" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:font-semibold file:text-blue-700" data-banner-file="image_file">
                                <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                    @if (!empty($banner['image_url']))
                                        <img src="{{ $banner['image_url'] }}" alt="Category banner preview" class="h-40 w-full object-cover">
                                    @else
                                        <div class="flex h-40 items-center justify-center bg-slate-100 text-sm font-medium text-slate-400">Chưa có ảnh nền</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <div class="flex justify-end">
            <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/20 transition-colors hover:bg-blue-700">Lưu slide và banner</button>
        </div>
    </form>

    <template id="home-slide-template">
        <div class="rounded-xl border border-slate-200 p-4" data-slide-row>
            <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                <strong class="text-sm text-slate-800" data-slide-title>Slide</strong>
                <button type="button" class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50" data-remove-slide>Xóa</button>
            </div>
            <div class="grid grid-cols-1 gap-5 xl:grid-cols-[1.35fr_0.85fr]">
                <div class="space-y-4">
                    <input type="text" data-slide-field="eyebrow" placeholder="Nhãn nhỏ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                    <textarea rows="3" data-slide-field="title" placeholder="Tiêu đề" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm"></textarea>
                    <textarea rows="4" data-slide-field="description" placeholder="Mô tả" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm"></textarea>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <input type="text" data-slide-field="primary_label" placeholder="Nút chính" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                        <input type="text" data-slide-field="primary_url" placeholder="Link nút chính" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <input type="text" data-slide-field="secondary_label" placeholder="Nút phụ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                        <input type="text" data-slide-field="secondary_url" placeholder="Link nút phụ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <input type="text" data-slide-field="highlight_label" placeholder="Nhãn thông tin" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                        <input type="text" data-slide-field="highlight_text" placeholder="Nội dung thông tin" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                    </div>
                    <input type="text" data-slide-field="card_title" placeholder="Tiêu đề thẻ phụ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                    <textarea rows="3" data-slide-field="card_text" placeholder="Mô tả thẻ phụ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm"></textarea>
                </div>
                <div class="space-y-4">
                    <input type="hidden" data-slide-field="image_url">
                    <input type="file" data-slide-file="image_file" accept="image/*" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                    <div class="flex h-52 items-center justify-center rounded-xl border border-slate-200 bg-slate-100 text-sm font-medium text-slate-400">Chưa có ảnh nền</div>
                </div>
            </div>
        </div>
    </template>

    <template id="home-banner-template">
        <div class="rounded-xl border border-slate-200 p-4" data-banner-row>
            <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                <strong class="text-sm text-slate-800" data-banner-title>Banner</strong>
                <button type="button" class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50" data-remove-banner>Xóa</button>
            </div>
            <div class="grid grid-cols-1 gap-5 xl:grid-cols-[1.2fr_0.8fr]">
                <div class="space-y-4">
                    <input type="text" data-banner-field="eyebrow" placeholder="Nhãn nhỏ" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                    <textarea rows="3" data-banner-field="title" placeholder="Tiêu đề banner" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm"></textarea>
                    <input type="text" data-banner-field="url" placeholder="Link banner" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                </div>
                <div class="space-y-4">
                    <input type="hidden" data-banner-field="image_url">
                    <input type="file" data-banner-file="image_file" accept="image/*" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                    <div class="flex h-40 items-center justify-center rounded-xl border border-slate-200 bg-slate-100 text-sm font-medium text-slate-400">Chưa có ảnh nền</div>
                </div>
            </div>
        </div>
    </template>

    <script>
        (() => {
            const slideRows = document.querySelector('[data-slide-rows]');
            const homeBannerRows = document.querySelector('[data-banner-rows="home"]');
            const categoryBannerRows = document.querySelector('[data-banner-rows="category"]');
            const slideTemplate = document.getElementById('home-slide-template');
            const bannerTemplate = document.getElementById('home-banner-template');

            const renumberSlides = () => {
                slideRows?.querySelectorAll('[data-slide-row]').forEach((row, index) => {
                    row.querySelector('[data-slide-title]')?.replaceChildren(`Slide ${index + 1}`);
                    row.querySelectorAll('[data-slide-field]').forEach((field) => {
                        field.setAttribute('name', `hero_slides[${index}][${field.dataset.slideField}]`);
                    });
                    row.querySelectorAll('[data-slide-file]').forEach((field) => {
                        field.setAttribute('name', `hero_slides[${index}][${field.dataset.slideFile}]`);
                    });
                });
            };

            const renumberBannerGroup = (container, group) => {
                container?.querySelectorAll('[data-banner-row]').forEach((row, index) => {
                    row.querySelector('[data-banner-title]')?.replaceChildren(`Banner ${index + 1}`);
                    row.querySelectorAll('[data-banner-field]').forEach((field) => {
                        field.setAttribute('name', `${group}[${index}][${field.dataset.bannerField}]`);
                    });
                    row.querySelectorAll('[data-banner-file]').forEach((field) => {
                        field.setAttribute('name', `${group}[${index}][${field.dataset.bannerFile}]`);
                    });
                });
            };

            document.querySelector('[data-add-slide]')?.addEventListener('click', () => {
                slideRows?.appendChild(slideTemplate.content.firstElementChild.cloneNode(true));
                renumberSlides();
            });

            document.querySelectorAll('[data-add-banner]').forEach((button) => {
                button.addEventListener('click', () => {
                    const target = button.dataset.addBanner;
                    const container = target === 'category' ? categoryBannerRows : homeBannerRows;
                    container?.appendChild(bannerTemplate.content.firstElementChild.cloneNode(true));
                    renumberBannerGroup(container, target === 'category' ? 'category_banners' : 'home_banners');
                });
            });

            document.addEventListener('click', (event) => {
                const removeSlide = event.target.closest('[data-remove-slide]');
                if (removeSlide) {
                    removeSlide.closest('[data-slide-row]')?.remove();
                    if (!slideRows?.children.length) {
                        slideRows?.appendChild(slideTemplate.content.firstElementChild.cloneNode(true));
                    }
                    renumberSlides();
                    return;
                }

                const removeBanner = event.target.closest('[data-remove-banner]');
                if (!removeBanner) {
                    return;
                }

                const row = removeBanner.closest('[data-banner-row]');
                const container = row?.parentElement;
                row?.remove();

                if (container === homeBannerRows) {
                    if (!homeBannerRows.children.length) {
                        homeBannerRows.appendChild(bannerTemplate.content.firstElementChild.cloneNode(true));
                    }
                    renumberBannerGroup(homeBannerRows, 'home_banners');
                }

                if (container === categoryBannerRows) {
                    if (!categoryBannerRows.children.length) {
                        categoryBannerRows.appendChild(bannerTemplate.content.firstElementChild.cloneNode(true));
                    }
                    renumberBannerGroup(categoryBannerRows, 'category_banners');
                }
            });

            renumberSlides();
            renumberBannerGroup(homeBannerRows, 'home_banners');
            renumberBannerGroup(categoryBannerRows, 'category_banners');
        })();
    </script>
</x-layouts.admin>
