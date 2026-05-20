<x-layouts.admin title="Cau hinh website">
    @php
        $settings = $settings ?? [];
        $site = $settings['site'] ?? [];
        $seo = $settings['seo'] ?? [];
        $contact = $settings['contact'] ?? [];
        $footer = $settings['footer'] ?? [];
        $menuToLines = fn (array $items) => collect($items)->map(fn ($item) => ($item['label'] ?? '').'|'.($item['url'] ?? ''))->implode("\n");
        $footerGroups = [
            'about_links' => old('footer.about_links', $footer['about_links'] ?? [['label' => '', 'url' => '']]),
            'policy_links' => old('footer.policy_links', $footer['policy_links'] ?? [['label' => '', 'url' => '']]),
            'support_links' => old('footer.support_links', $footer['support_links'] ?? [['label' => '', 'url' => '']]),
        ];
    @endphp

    @if (session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <div class="font-semibold">Vui long kiem tra lai du lieu nhap.</div>
            <ul class="mt-2 list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Cau hinh website</h1>
        <p class="mt-1 text-sm text-slate-500">Quan ly logo, favicon, menu, footer va SEO mac dinh cho Tech One.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.general.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <section class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
                <div class="mb-5 border-b border-slate-100 pb-4"><h2 class="text-lg font-bold text-slate-800">Nhan dien thuong hieu</h2></div>
                <div class="space-y-5">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Ten website</label>
                        <input type="text" name="site[site_name]" value="{{ old('site.site_name', $site['site_name'] ?? 'Tech One') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Tieu de phu</label>
                        <input type="text" name="site[site_tagline]" value="{{ old('site.site_tagline', $site['site_tagline'] ?? 'Tech One') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Alt logo</label>
                        <input type="text" name="site[logo_alt]" value="{{ old('site.logo_alt', $site['logo_alt'] ?? 'Tech One') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Logo</label>
                        <input type="file" name="site[logo_file]" accept="image/*" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:font-semibold file:text-blue-700">
                        @if (!empty($site['logo_url']))
                            <img src="{{ $site['logo_url'] }}" alt="{{ $site['logo_alt'] ?? '' }}" class="mt-3 h-16 rounded-lg border border-slate-200 bg-slate-50 p-2">
                        @endif
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Favicon</label>
                        <input type="file" name="site[favicon_file]" accept="image/*" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:font-semibold file:text-blue-700">
                        @if (!empty($site['favicon_url']))
                            <img src="{{ $site['favicon_url'] }}" alt="Favicon" class="mt-3 h-12 w-12 rounded-lg border border-slate-200 bg-slate-50 p-2 object-contain">
                        @endif
                    </div>
                </div>
            </section>

            <section class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
                <div class="mb-5 border-b border-slate-100 pb-4"><h2 class="text-lg font-bold text-slate-800">SEO mac dinh</h2></div>
                <div class="space-y-5">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Meta title</label>
                        <input type="text" name="seo[meta_title]" value="{{ old('seo.meta_title', $seo['meta_title'] ?? 'Tech One') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Meta description</label>
                        <textarea name="seo[meta_description]" rows="4" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ old('seo.meta_description', $seo['meta_description'] ?? 'Tech One - cua hang cong nghe, dien thoai, laptop va phu kien chinh hang.') }}</textarea>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Meta keywords</label>
                        <textarea name="seo[meta_keywords]" rows="3" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ old('seo.meta_keywords', $seo['meta_keywords'] ?? 'tech one, dien thoai, laptop, phu kien, cong nghe') }}</textarea>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">OG image</label>
                        <input type="file" name="seo[og_image_file]" accept="image/*" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:font-semibold file:text-blue-700">
                        @if (!empty($seo['og_image_url']))
                            <img src="{{ $seo['og_image_url'] }}" alt="OG image" class="mt-3 h-20 rounded-lg border border-slate-200 bg-slate-50 p-2">
                        @endif
                    </div>
                </div>
            </section>
        </div>

        <section class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
            <div class="mb-5 border-b border-slate-100 pb-4"><h2 class="text-lg font-bold text-slate-800">Lien he</h2></div>
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                <input type="text" name="contact[hotline]" value="{{ old('contact.hotline', $contact['hotline'] ?? '') }}" placeholder="Hotline" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                <input type="email" name="contact[email]" value="{{ old('contact.email', $contact['email'] ?? '') }}" placeholder="Email" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                <input type="text" name="contact[address]" value="{{ old('contact.address', $contact['address'] ?? '') }}" placeholder="Dia chi" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                <input type="text" name="contact[working_hours]" value="{{ old('contact.working_hours', $contact['working_hours'] ?? '') }}" placeholder="Gio lam viec" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
            </div>
        </section>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <section class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
                <div class="mb-5 border-b border-slate-100 pb-4">
                    <h2 class="text-lg font-bold text-slate-800">Menu header</h2>
                    <p class="mt-1 text-xs text-slate-500">Moi dong theo dinh dang `Ten menu|URL`.</p>
                </div>
                <textarea name="header_menu" rows="10" class="w-full rounded-lg border border-slate-300 px-4 py-3 font-mono text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ old('header_menu', $menuToLines($settings['header_menu'] ?? [])) }}</textarea>
            </section>

            <section class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
                <div class="mb-5 border-b border-slate-100 pb-4">
                    <h2 class="text-lg font-bold text-slate-800">Footer</h2>
                    <p class="mt-1 text-xs text-slate-500">Moi item gom ten hien thi va link de nguoi dung co the click truc tiep o footer.</p>
                </div>
                <div class="space-y-6">
                    @foreach ([
                        'about_links' => ['title' => 'Nhom 1', 'input' => 'footer[about_title]', 'value' => old('footer.about_title', $footer['about_title'] ?? 'Tech One')],
                        'policy_links' => ['title' => 'Nhom 2', 'input' => 'footer[policy_title]', 'value' => old('footer.policy_title', $footer['policy_title'] ?? 'Chinh sach')],
                        'support_links' => ['title' => 'Nhom 3', 'input' => 'footer[support_title]', 'value' => old('footer.support_title', $footer['support_title'] ?? 'Ho tro')],
                    ] as $groupKey => $groupMeta)
                        <div class="rounded-xl border border-slate-200 p-4" data-link-group="{{ $groupKey }}">
                            <div class="flex items-center justify-between gap-3">
                                <input type="text" name="{{ $groupMeta['input'] }}" value="{{ $groupMeta['value'] }}" placeholder="{{ $groupMeta['title'] }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                <button type="button" class="shrink-0 rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50" data-add-link-row="{{ $groupKey }}">Them item</button>
                            </div>
                            <div class="mt-3 space-y-3" data-link-rows="{{ $groupKey }}">
                                @foreach ($footerGroups[$groupKey] as $index => $item)
                                    <div class="grid grid-cols-1 gap-3 md:grid-cols-[1fr_1fr_auto]" data-link-row>
                                        <input type="text" name="footer[{{ $groupKey }}][{{ $index }}][label]" value="{{ $item['label'] ?? '' }}" placeholder="Ten hien thi" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                        <input type="text" name="footer[{{ $groupKey }}][{{ $index }}][url]" value="{{ $item['url'] ?? '' }}" placeholder="https://example.com hoac /duong-dan" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                        <button type="button" class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50" data-remove-link-row>Xoa</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div>
                        <input type="text" name="footer[copyright_text]" value="{{ old('footer.copyright_text', $footer['copyright_text'] ?? '© 2026 Tech One. Tat ca cac quyen duoc bao luu.') }}" placeholder="Dong ban quyen" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                </div>
            </section>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/20 transition-colors hover:bg-blue-700">Luu cau hinh</button>
        </div>
    </form>

    <template id="footer-link-row-template">
        <div class="grid grid-cols-1 gap-3 md:grid-cols-[1fr_1fr_auto]" data-link-row>
            <input type="text" data-field="label" placeholder="Ten hien thi" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
            <input type="text" data-field="url" placeholder="https://example.com hoac /duong-dan" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
            <button type="button" class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50" data-remove-link-row>Xoa</button>
        </div>
    </template>

    <script>
        (() => {
            const footerTemplate = document.getElementById('footer-link-row-template');

            const renumberRows = (groupKey) => {
                const rows = document.querySelectorAll(`[data-link-rows="${groupKey}"] [data-link-row]`);

                rows.forEach((row, index) => {
                    row.querySelector('[data-field="label"], input[name*="[label]"]')?.setAttribute('name', `footer[${groupKey}][${index}][label]`);
                    row.querySelector('[data-field="url"], input[name*="[url]"]')?.setAttribute('name', `footer[${groupKey}][${index}][url]`);
                });
            };

            document.querySelectorAll('[data-add-link-row]').forEach((button) => {
                button.addEventListener('click', () => {
                    const groupKey = button.dataset.addLinkRow;
                    const container = document.querySelector(`[data-link-rows="${groupKey}"]`);
                    const row = footerTemplate.content.firstElementChild.cloneNode(true);

                    container.appendChild(row);
                    renumberRows(groupKey);
                });
            });

            document.addEventListener('click', (event) => {
                const removeButton = event.target.closest('[data-remove-link-row]');
                if (!removeButton) {
                    return;
                }

                const row = removeButton.closest('[data-link-row]');
                const container = row.parentElement;

                row.remove();

                if (!container.children.length) {
                    const groupKey = container.dataset.linkRows;
                    const newRow = footerTemplate.content.firstElementChild.cloneNode(true);
                    container.appendChild(newRow);
                }

                renumberRows(container.dataset.linkRows);
            });
        })();
    </script>
</x-layouts.admin>
