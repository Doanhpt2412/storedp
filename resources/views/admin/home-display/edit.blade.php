<x-layouts.admin title="Slide & Banner">
    @php
        $slides = old('hero_slides', $slides ?? []);
        $banners = old('home_banners', $banners ?? []);
    @endphp

    @if (session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <div class="font-semibold">Vui long kiem tra lai du lieu nhap.</div>
            <ul class="mt-2 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Slide & Banner trang chu</h1>
        <p class="mt-1 text-sm text-slate-500">Quan ly slide hero co anh nen, noi dung hien thi va cac banner nho ben duoi.</p>
    </div>

    <form method="POST" action="{{ route('admin.homepage.display.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <section class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
            <div class="mb-5 border-b border-slate-100 pb-4">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Slide hero</h2>
                        <p class="mt-1 text-xs text-slate-500">Moi slide co anh nen, tieu de, mo ta va 2 nut dieu huong.</p>
                    </div>
                    <button type="button" class="shrink-0 rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50" data-add-slide>Them slide</button>
                </div>
            </div>

            <div class="space-y-4" data-slide-rows>
                @foreach ($slides as $index => $slide)
                    <div class="rounded-xl border border-slate-200 p-4" data-slide-row>
                        <div class="mb-4 flex items-center justify-between gap-3 border-b border-slate-100 pb-3">
                            <strong class="text-sm text-slate-800" data-slide-title>Slide {{ $loop->iteration }}</strong>
                            <button type="button" class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50" data-remove-slide>Xoa</button>
                        </div>

                        <div class="grid grid-cols-1 gap-5 xl:grid-cols-[1.35fr_0.85fr]">
                            <div class="space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nhom nho</label>
                                    <input type="text" name="hero_slides[{{ $index }}][eyebrow]" value="{{ $slide['eyebrow'] ?? '' }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" data-slide-field="eyebrow">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Tieu de</label>
                                    <textarea name="hero_slides[{{ $index }}][title]" rows="3" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" data-slide-field="title">{{ $slide['title'] ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Mo ta</label>
                                    <textarea name="hero_slides[{{ $index }}][description]" rows="4" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ $slide['description'] ?? '' }}</textarea>
                                </div>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nut chinh</label>
                                        <input type="text" name="hero_slides[{{ $index }}][primary_label]" value="{{ $slide['primary_label'] ?? '' }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Link nut chinh</label>
                                        <input type="text" name="hero_slides[{{ $index }}][primary_url]" value="{{ $slide['primary_url'] ?? '' }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nut phu</label>
                                        <input type="text" name="hero_slides[{{ $index }}][secondary_label]" value="{{ $slide['secondary_label'] ?? '' }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Link nut phu</label>
                                        <input type="text" name="hero_slides[{{ $index }}][secondary_url]" value="{{ $slide['secondary_url'] ?? '' }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nhan thong tin</label>
                                        <input type="text" name="hero_slides[{{ $index }}][highlight_label]" value="{{ $slide['highlight_label'] ?? '' }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Noi dung thong tin</label>
                                        <input type="text" name="hero_slides[{{ $index }}][highlight_text]" value="{{ $slide['highlight_text'] ?? '' }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Tieu de the ben phai</label>
                                    <input type="text" name="hero_slides[{{ $index }}][card_title]" value="{{ $slide['card_title'] ?? '' }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Mo ta the ben phai</label>
                                    <textarea name="hero_slides[{{ $index }}][card_text]" rows="3" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ $slide['card_text'] ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Anh nen slide</label>
                                    <input type="hidden" name="hero_slides[{{ $index }}][image_url]" value="{{ $slide['image_url'] ?? '' }}" data-slide-field="image_url">
                                    <input type="file" name="hero_slides[{{ $index }}][image_file]" accept="image/*" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:font-semibold file:text-blue-700">
                                </div>
                                <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                    @if (!empty($slide['image_url']))
                                        <img src="{{ $slide['image_url'] }}" alt="Slide preview" class="h-52 w-full object-cover">
                                    @else
                                        <div class="flex h-52 items-center justify-center bg-slate-100 text-sm font-medium text-slate-400">Chua co anh nen</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
            <div class="mb-5 border-b border-slate-100 pb-4">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Banner nho</h2>
                        <p class="mt-1 text-xs text-slate-500">Quan ly cac banner hien thi ben duoi hero. Co the gan link va anh nen rieng.</p>
                    </div>
                    <button type="button" class="shrink-0 rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50" data-add-banner>Them banner</button>
                </div>
            </div>

            <div class="space-y-4" data-banner-rows>
                @foreach ($banners as $index => $banner)
                    <div class="rounded-xl border border-slate-200 p-4" data-banner-row>
                        <div class="mb-4 flex items-center justify-between gap-3 border-b border-slate-100 pb-3">
                            <strong class="text-sm text-slate-800" data-banner-title>Banner {{ $loop->iteration }}</strong>
                            <button type="button" class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50" data-remove-banner>Xoa</button>
                        </div>

                        <div class="grid grid-cols-1 gap-5 xl:grid-cols-[1.2fr_0.8fr]">
                            <div class="space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nhan nho</label>
                                    <input type="text" name="home_banners[{{ $index }}][eyebrow]" value="{{ $banner['eyebrow'] ?? '' }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" data-banner-field="eyebrow">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Tieu de banner</label>
                                    <textarea name="home_banners[{{ $index }}][title]" rows="3" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" data-banner-field="title">{{ $banner['title'] ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Link banner</label>
                                    <input type="text" name="home_banners[{{ $index }}][url]" value="{{ $banner['url'] ?? '' }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Anh nen banner</label>
                                    <input type="hidden" name="home_banners[{{ $index }}][image_url]" value="{{ $banner['image_url'] ?? '' }}" data-banner-field="image_url">
                                    <input type="file" name="home_banners[{{ $index }}][image_file]" accept="image/*" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:font-semibold file:text-blue-700">
                                </div>
                                <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                    @if (!empty($banner['image_url']))
                                        <img src="{{ $banner['image_url'] }}" alt="Banner preview" class="h-40 w-full object-cover">
                                    @else
                                        <div class="flex h-40 items-center justify-center bg-slate-100 text-sm font-medium text-slate-400">Chua co anh nen</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <div class="flex justify-end">
            <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/20 transition-colors hover:bg-blue-700">Luu slide va banner</button>
        </div>
    </form>

    <template id="home-slide-template">
        <div class="rounded-xl border border-slate-200 p-4" data-slide-row>
            <div class="mb-4 flex items-center justify-between gap-3 border-b border-slate-100 pb-3">
                <strong class="text-sm text-slate-800" data-slide-title>Slide</strong>
                <button type="button" class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50" data-remove-slide>Xoa</button>
            </div>

            <div class="grid grid-cols-1 gap-5 xl:grid-cols-[1.35fr_0.85fr]">
                <div class="space-y-4">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nhom nho</label>
                        <input type="text" data-slide-field="eyebrow" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Tieu de</label>
                        <textarea rows="3" data-slide-field="title" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"></textarea>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Mo ta</label>
                        <textarea rows="4" data-slide-field="description" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"></textarea>
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <input type="text" data-slide-field="primary_label" placeholder="Nut chinh" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <input type="text" data-slide-field="primary_url" placeholder="Link nut chinh" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <input type="text" data-slide-field="secondary_label" placeholder="Nut phu" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <input type="text" data-slide-field="secondary_url" placeholder="Link nut phu" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <input type="text" data-slide-field="highlight_label" placeholder="Nhan thong tin" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <input type="text" data-slide-field="highlight_text" placeholder="Noi dung thong tin" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <input type="text" data-slide-field="card_title" placeholder="Tieu de the ben phai" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    <textarea rows="3" data-slide-field="card_text" placeholder="Mo ta the ben phai" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"></textarea>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Anh nen slide</label>
                        <input type="hidden" data-slide-field="image_url">
                        <input type="file" data-slide-file="image_file" accept="image/*" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:font-semibold file:text-blue-700">
                    </div>
                    <div class="flex h-52 items-center justify-center rounded-xl border border-slate-200 bg-slate-100 text-sm font-medium text-slate-400">Chua co anh nen</div>
                </div>
            </div>
        </div>
    </template>

    <template id="home-banner-template">
        <div class="rounded-xl border border-slate-200 p-4" data-banner-row>
            <div class="mb-4 flex items-center justify-between gap-3 border-b border-slate-100 pb-3">
                <strong class="text-sm text-slate-800" data-banner-title>Banner</strong>
                <button type="button" class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50" data-remove-banner>Xoa</button>
            </div>

            <div class="grid grid-cols-1 gap-5 xl:grid-cols-[1.2fr_0.8fr]">
                <div class="space-y-4">
                    <input type="text" data-banner-field="eyebrow" placeholder="Nhan nho" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    <textarea rows="3" data-banner-field="title" placeholder="Tieu de banner" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"></textarea>
                    <input type="text" data-banner-field="url" placeholder="Link banner" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Anh nen banner</label>
                        <input type="hidden" data-banner-field="image_url">
                        <input type="file" data-banner-file="image_file" accept="image/*" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:font-semibold file:text-blue-700">
                    </div>
                    <div class="flex h-40 items-center justify-center rounded-xl border border-slate-200 bg-slate-100 text-sm font-medium text-slate-400">Chua co anh nen</div>
                </div>
            </div>
        </div>
    </template>

    <script>
        (() => {
            const slideRows = document.querySelector('[data-slide-rows]');
            const bannerRows = document.querySelector('[data-banner-rows]');
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

            const renumberBanners = () => {
                bannerRows?.querySelectorAll('[data-banner-row]').forEach((row, index) => {
                    row.querySelector('[data-banner-title]')?.replaceChildren(`Banner ${index + 1}`);
                    row.querySelectorAll('[data-banner-field]').forEach((field) => {
                        field.setAttribute('name', `home_banners[${index}][${field.dataset.bannerField}]`);
                    });
                    row.querySelectorAll('[data-banner-file]').forEach((field) => {
                        field.setAttribute('name', `home_banners[${index}][${field.dataset.bannerFile}]`);
                    });
                });
            };

            document.querySelector('[data-add-slide]')?.addEventListener('click', () => {
                slideRows?.appendChild(slideTemplate.content.firstElementChild.cloneNode(true));
                renumberSlides();
            });

            document.querySelector('[data-add-banner]')?.addEventListener('click', () => {
                bannerRows?.appendChild(bannerTemplate.content.firstElementChild.cloneNode(true));
                renumberBanners();
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
                if (removeBanner) {
                    removeBanner.closest('[data-banner-row]')?.remove();
                    if (!bannerRows?.children.length) {
                        bannerRows?.appendChild(bannerTemplate.content.firstElementChild.cloneNode(true));
                    }
                    renumberBanners();
                }
            });

            renumberSlides();
            renumberBanners();
        })();
    </script>
</x-layouts.admin>
