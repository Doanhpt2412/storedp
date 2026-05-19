@php
    $variantRows = old('variants', $product->exists ? $product->variants->map(fn ($variant) => [
        'sku' => $variant->sku,
        'storage' => $variant->storage,
        'color_name' => $variant->color_name,
        'color_code' => $variant->color_code,
        'price_original' => (float) $variant->price_original,
        'price_sale' => $variant->price_sale !== null ? (float) $variant->price_sale : null,
        'stock' => $variant->stock,
    ])->values()->all() : [[
        'sku' => '',
        'storage' => '256GB',
        'color_name' => '',
        'color_code' => '#ffffff',
        'price_original' => 0,
        'price_sale' => null,
        'stock' => 0,
    ]]);

    $specRows = old('specifications', $product->exists ? $product->specifications->map(fn ($spec) => [
        'group_name' => $spec->group_name,
        'name' => $spec->name,
        'value' => $spec->value,
        'sort_order' => $spec->sort_order,
    ])->values()->all() : [
        ['group_name' => 'Màn hình', 'name' => 'Công nghệ màn hình', 'value' => '', 'sort_order' => 0],
        ['group_name' => 'Hiệu năng', 'name' => 'Vi xử lý', 'value' => '', 'sort_order' => 10],
        ['group_name' => 'Camera', 'name' => 'Camera sau', 'value' => '', 'sort_order' => 20],
        ['group_name' => 'Pin & Sạc', 'name' => 'Công suất sạc nhanh', 'value' => '', 'sort_order' => 30],
    ]);
@endphp

@if($errors->any())
    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
        <div class="font-semibold">Vui lòng kiểm tra lại dữ liệu nhập.</div>
        <ul class="mt-2 list-inside list-disc">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6" data-product-form>
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
        <div class="mb-5 border-b border-slate-100 pb-4">
            <h2 class="text-lg font-bold text-slate-800">Thông tin chung</h2>
        </div>
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div>
                <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Tên sản phẩm <span class="text-rose-500">*</span></label>
                <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" placeholder="Apple iPhone 17" data-slug-source>
            </div>
            <div>
                <label for="slug" class="mb-1.5 block text-sm font-semibold text-slate-700">Slug</label>
                <input id="slug" name="slug" type="text" value="{{ old('slug', $product->slug) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 font-mono text-sm outline-none transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" placeholder="apple-iphone-17" data-slug-target>
            </div>
            <div>
                <label for="product_category_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Danh mục</label>
                <select id="product_category_id" name="product_category_id" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('product_category_id', $product->product_category_id) === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="product_brand_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Hãng sản xuất</label>
                <select id="product_brand_id" name="product_brand_id" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    <option value="">Chọn hãng</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" @selected((string) old('product_brand_id', $product->product_brand_id) === (string) $brand->id)>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="thumbnail_file" class="mb-1.5 block text-sm font-semibold text-slate-700">Ảnh đại diện</label>
                <input id="thumbnail_file" name="thumbnail_file" type="file" accept="image/jpeg,image/png,image/webp" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition-all file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-blue-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                <div class="{{ $product->thumbnail ? '' : 'hidden' }} mt-3 w-36 overflow-hidden rounded-lg border border-slate-200 bg-slate-50 p-2" data-thumbnail-preview-wrap>
                    <img src="{{ $product->thumbnail }}" alt="{{ $product->name ?: 'Ảnh đại diện' }}" class="h-28 w-full rounded-md object-cover" data-thumbnail-preview>
                    <p class="mt-2 truncate text-xs text-slate-500" data-thumbnail-preview-label>{{ $product->thumbnail ? 'Ảnh hiện tại' : '' }}</p>
                </div>
            </div>
            <div class="lg:col-span-2">
                <label for="images_files" class="mb-1.5 block text-sm font-semibold text-slate-700">Album ảnh</label>
                <input id="images_files" name="images_files[]" type="file" multiple accept="image/jpeg,image/png,image/webp" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition-all file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-blue-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                <p class="mt-2 text-xs text-slate-500">Kéo ảnh để đổi vị trí. Bấm xóa để bỏ ảnh khỏi album trước khi lưu.</p>
                <div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-4 lg:grid-cols-6" data-album-list>
                    @foreach(($product->images ?? []) as $image)
                        <div class="group relative block overflow-hidden rounded-lg border border-slate-200 bg-slate-50 p-2" draggable="true" data-album-item data-type="existing" data-value="{{ $image }}">
                            <input type="hidden" name="existing_images[]" value="{{ $image }}">
                            <input type="hidden" name="album_order[]" value="existing:{{ $image }}" data-album-order>
                            <img src="{{ $image }}" alt="{{ $product->name ?: 'Ảnh album' }} {{ $loop->iteration }}" class="h-24 w-full rounded-md object-cover">
                            <div class="mt-2 flex items-center justify-between gap-2">
                                <span class="truncate text-xs text-slate-500">Ảnh {{ $loop->iteration }}</span>
                                <button type="button" class="rounded-md bg-rose-50 px-2 py-1 text-xs font-semibold text-rose-600 hover:bg-rose-100" data-remove-album>Xóa</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <template data-album-template>
                    <div class="group relative block overflow-hidden rounded-lg border border-slate-200 bg-slate-50 p-2" draggable="true" data-album-item data-type="new">
                        <input type="hidden" name="album_order[]" value="" data-album-order>
                        <img src="" alt="Ảnh album mới" class="h-24 w-full rounded-md object-cover">
                        <div class="mt-2 flex items-center justify-between gap-2">
                            <span class="truncate text-xs text-slate-500" data-file-name>Ảnh mới</span>
                            <button type="button" class="rounded-md bg-rose-50 px-2 py-1 text-xs font-semibold text-rose-600 hover:bg-rose-100" data-remove-album>Xóa</button>
                        </div>
                    </div>
                </template>
            </div>
            <div>
                <label for="status" class="mb-1.5 block text-sm font-semibold text-slate-700">Trạng thái</label>
                <select id="status" name="status" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" @selected((string) old('status', $product->status ?? \App\Models\Product::STATUS_ACTIVE) === (string) $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lg:col-span-2">
                <label class="inline-flex cursor-pointer items-center select-none">
                    <input type="checkbox" name="is_preorder" value="1" class="sr-only peer" @checked(old('is_preorder', $product->is_preorder))>
                    <span class="relative h-6 w-11 rounded-full bg-slate-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-slate-300 after:bg-white after:transition-all peer-checked:bg-blue-600 peer-checked:after:translate-x-full"></span>
                    <span class="ms-3 text-sm font-semibold text-slate-700">Sản phẩm đặt trước</span>
                </label>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
        <div class="mb-5 flex items-center justify-between border-b border-slate-100 pb-4">
            <h2 class="text-lg font-bold text-slate-800">Biến thể và giá bán</h2>
            <button type="button" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50" data-add-variant>Thêm biến thể</button>
        </div>
        <div class="space-y-3" data-variant-list></div>
    </div>

    <div class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
        <div class="mb-5 flex items-center justify-between border-b border-slate-100 pb-4">
            <h2 class="text-lg font-bold text-slate-800">Thông số kỹ thuật</h2>
            <button type="button" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50" data-add-spec>Thêm thông số</button>
        </div>
        <div class="space-y-3" data-spec-list></div>
    </div>

    <div class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
        <div class="mb-5 border-b border-slate-100 pb-4">
            <h2 class="text-lg font-bold text-slate-800">Nội dung và chính sách</h2>
        </div>
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div>
                <label for="warranty_policy" class="mb-1.5 block text-sm font-semibold text-slate-700">Chính sách bảo hành</label>
                <input id="warranty_policy" name="warranty_policy" type="text" value="{{ old('warranty_policy', $product->warranty_policy) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
            </div>
            <div>
                <label for="return_policy" class="mb-1.5 block text-sm font-semibold text-slate-700">Chính sách đổi trả</label>
                <input id="return_policy" name="return_policy" type="text" value="{{ old('return_policy', $product->return_policy) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
            </div>
            <div class="lg:col-span-2">
                <label for="highlights_text" class="mb-1.5 block text-sm font-semibold text-slate-700">Ưu đãi nổi bật</label>
                <textarea id="highlights_text" name="highlights_text" rows="3" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" placeholder="Mỗi dòng một ưu đãi">{{ old('highlights_text', implode("\n", $product->highlights ?? [])) }}</textarea>
            </div>
            <div class="lg:col-span-2">
                <label for="summary" class="mb-1.5 block text-sm font-semibold text-slate-700">Mô tả ngắn</label>
                <textarea id="summary" name="summary" rows="3" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ old('summary', $product->summary) }}</textarea>
            </div>
            <div class="lg:col-span-2">
                <label for="description" class="mb-1.5 block text-sm font-semibold text-slate-700">Bài viết đánh giá HTML</label>
                <textarea id="description" name="description" rows="10" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 font-mono text-sm outline-none transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50">Hủy bỏ</a>
        <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-md shadow-blue-500/20 transition-colors hover:bg-blue-700">Lưu sản phẩm</button>
    </div>
</form>

<script>
    (() => {
        const slugSource = document.querySelector('[data-slug-source]');
        const slugTarget = document.querySelector('[data-slug-target]');
        const thumbnailInput = document.getElementById('thumbnail_file');
        const thumbnailWrap = document.querySelector('[data-thumbnail-preview-wrap]');
        const thumbnailPreview = document.querySelector('[data-thumbnail-preview]');
        const thumbnailLabel = document.querySelector('[data-thumbnail-preview-label]');
        const albumInput = document.getElementById('images_files');
        const albumList = document.querySelector('[data-album-list]');
        const albumTemplate = document.querySelector('[data-album-template]');
        const variantList = document.querySelector('[data-variant-list]');
        const specList = document.querySelector('[data-spec-list]');
        let variantRows = @json($variantRows);
        let specRows = @json($specRows);
        let albumFiles = [];
        let draggedAlbumItem = null;

        const escapeHtml = (value) => String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        const slugify = (value) => value.toString().normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/đ/g, 'd')
            .replace(/Đ/g, 'd')
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');

        if (slugSource && slugTarget) {
            slugSource.addEventListener('input', () => {
                if (!slugTarget.dataset.touched) {
                    slugTarget.value = slugify(slugSource.value);
                }
            });
            slugTarget.addEventListener('input', () => slugTarget.dataset.touched = '1');
        }

        const syncAlbumState = () => {
            if (!albumInput) return;

            const transfer = new DataTransfer();
            let newIndex = 0;

            albumList?.querySelectorAll('[data-album-item]').forEach((item) => {
                const orderInput = item.querySelector('[data-album-order]');
                if (!orderInput) return;

                if (item.dataset.type === 'existing') {
                    orderInput.value = `existing:${item.dataset.value || ''}`;
                    return;
                }

                const file = albumFiles[Number(item.dataset.fileIndex)];
                if (file) {
                    transfer.items.add(file);
                    orderInput.value = `new:${newIndex}`;
                    newIndex += 1;
                }
            });

            albumInput.files = transfer.files;
        };

        const renumberExistingAlbumInputs = () => {
            albumList?.querySelectorAll('[data-album-item][data-type="existing"]').forEach((item) => {
                const input = item.querySelector('input[name="existing_images[]"]');
                if (input) input.value = item.dataset.value || '';
            });
        };

        const attachAlbumItemEvents = (item) => {
            item.addEventListener('dragstart', () => {
                draggedAlbumItem = item;
                item.classList.add('opacity-60');
            });

            item.addEventListener('dragend', () => {
                item.classList.remove('opacity-60');
                draggedAlbumItem = null;
                syncAlbumState();
                renumberExistingAlbumInputs();
            });

            item.addEventListener('dragover', (event) => {
                event.preventDefault();
                if (!draggedAlbumItem || draggedAlbumItem === item) return;

                const rect = item.getBoundingClientRect();
                const insertAfter = event.clientY > rect.top + rect.height / 2;
                albumList.insertBefore(draggedAlbumItem, insertAfter ? item.nextSibling : item);
            });

            item.querySelector('[data-remove-album]')?.addEventListener('click', () => {
                item.remove();
                syncAlbumState();
                renumberExistingAlbumInputs();
            });
        };

        albumList?.querySelectorAll('[data-album-item]').forEach(attachAlbumItemEvents);

        thumbnailInput?.addEventListener('change', () => {
            const file = thumbnailInput.files?.[0];
            if (!file || !thumbnailPreview || !thumbnailWrap) return;

            thumbnailPreview.src = URL.createObjectURL(file);
            thumbnailWrap.classList.remove('hidden');
            if (thumbnailLabel) thumbnailLabel.textContent = file.name;
        });

        albumInput?.addEventListener('change', () => {
            const selectedFiles = Array.from(albumInput.files || []);

            selectedFiles.forEach((file) => {
                const template = albumTemplate.content.firstElementChild.cloneNode(true);
                const fileIndex = albumFiles.push(file) - 1;

                template.dataset.fileIndex = String(fileIndex);
                template.querySelector('img').src = URL.createObjectURL(file);
                template.querySelector('[data-file-name]').textContent = file.name;
                attachAlbumItemEvents(template);
                albumList.appendChild(template);
            });

            syncAlbumState();
        });

        document.querySelector('[data-product-form]')?.addEventListener('submit', syncAlbumState);

        const renderVariants = () => {
            variantList.innerHTML = variantRows.map((row, index) => `
                <div class="grid grid-cols-1 gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3 lg:grid-cols-8" data-row>
                    <input name="variants[${index}][sku]" value="${escapeHtml(row.sku)}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm lg:col-span-2" placeholder="SKU">
                    <input name="variants[${index}][storage]" value="${escapeHtml(row.storage)}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Dung lượng">
                    <input name="variants[${index}][color_name]" value="${escapeHtml(row.color_name)}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Màu">
                    <input name="variants[${index}][color_code]" value="${escapeHtml(row.color_code ?? '#ffffff')}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="#ffffff">
                    <input name="variants[${index}][price_original]" value="${escapeHtml(row.price_original ?? 0)}" type="number" min="0" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Giá gốc">
                    <input name="variants[${index}][price_sale]" value="${escapeHtml(row.price_sale)}" type="number" min="0" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Giá bán">
                    <div class="flex gap-2">
                        <input name="variants[${index}][stock]" value="${escapeHtml(row.stock ?? 0)}" type="number" min="0" class="min-w-0 flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Tồn">
                        <button type="button" class="rounded-lg border border-rose-200 px-3 text-sm font-semibold text-rose-600" data-remove-variant="${index}">Xóa</button>
                    </div>
                </div>
            `).join('');
        };

        const renderSpecs = () => {
            specList.innerHTML = specRows.map((row, index) => `
                <div class="grid grid-cols-1 gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3 lg:grid-cols-12" data-row>
                    <input name="specifications[${index}][group_name]" value="${escapeHtml(row.group_name)}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm lg:col-span-2" placeholder="Nhóm">
                    <input name="specifications[${index}][name]" value="${escapeHtml(row.name)}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm lg:col-span-3" placeholder="Tên thuộc tính">
                    <input name="specifications[${index}][value]" value="${escapeHtml(row.value)}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm lg:col-span-5" placeholder="Giá trị">
                    <input name="specifications[${index}][sort_order]" value="${escapeHtml(row.sort_order ?? 0)}" type="number" min="0" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Thứ tự">
                    <button type="button" class="rounded-lg border border-rose-200 px-3 text-sm font-semibold text-rose-600" data-remove-spec="${index}">Xóa</button>
                </div>
            `).join('');
        };

        document.querySelector('[data-add-variant]')?.addEventListener('click', () => {
            variantRows.push({ sku: '', storage: '', color_name: '', color_code: '#ffffff', price_original: 0, price_sale: '', stock: 0 });
            renderVariants();
        });

        document.querySelector('[data-add-spec]')?.addEventListener('click', () => {
            specRows.push({ group_name: '', name: '', value: '', sort_order: specRows.length * 10 });
            renderSpecs();
        });

        document.addEventListener('click', (event) => {
            const variantIndex = event.target.getAttribute('data-remove-variant');
            const specIndex = event.target.getAttribute('data-remove-spec');

            if (variantIndex !== null) {
                variantRows.splice(Number(variantIndex), 1);
                renderVariants();
            }

            if (specIndex !== null) {
                specRows.splice(Number(specIndex), 1);
                renderSpecs();
            }
        });

        renderVariants();
        renderSpecs();
    })();
</script>
