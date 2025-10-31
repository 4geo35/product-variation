<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить вариацию</x-slot>
    <x-slot name="text">Будет невозможно восстановить вариацию!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">
        {{ $variationId ? "Редактировать вариацию" : "Добавить вариацию" }}
    </x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $variationId ? 'update' : 'store' }}"
              class="space-y-indent-half" id="variationDataForm">
            <div>
                <label for="variationTitle" class="inline-block mb-2">
                    Заголовок<span class="text-danger">*</span>
                </label>
                <input type="text" id="variationTitle" required
                       class="form-control {{ $errors->has("title") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="title">
                <x-tt::form.error name="title"/>
            </div>

            <div>
                <div class="inline-block mb-2">Единица измерения</div>
                @isset($units)
                    <select class="form-select {{ $errors->has('unit') ? 'border-danger' : '' }}" wire:model="unit">
                        <option value="">Выберите...</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->title }}</option>
                        @endforeach
                    </select>
                    <x-tt::form.error name="unit"/>
                @endisset
            </div>

            <div>
                <label for="variationPrice" class="inline-block mb-2">
                    Цена<span class="text-danger">*</span>
                </label>
                <input type="number" id="variationPrice" min="0" step=".01"
                       class="form-control {{ $errors->has("price") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="price">
                <x-tt::form.error name="price"/>
            </div>

            <div>
                <label for="variationOldPrice" class="inline-block mb-2">
                    Цена без скидки
                </label>
                <input type="text" id="variationOldPrice"
                       class="form-control {{ $errors->has("oldPrice") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="oldPrice">
                <x-tt::form.error name="oldPrice"/>
            </div>

            <div class="form-check">
                <input type="checkbox" wire:model="sale" id="variationSale"
                       class="form-check-input {{ $errors->has('sale') ? 'border-danger' : '' }}"/>
                <label for="variationSale" class="form-check-label">
                    Активировать скидку
                </label>
            </div>

            <div>
                <label for="variationSku" class="inline-block mb-2">
                    Артикул
                </label>
                <input type="text" id="variationSku"
                       class="form-control {{ $errors->has("sku") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="sku">
                <x-tt::form.error name="sku"/>
                <div class="text-sm text-secondary">Если оставить пустым, сформируется автоматически</div>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="variationDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $variationId ? 'Обновить' : 'Добавить' }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
