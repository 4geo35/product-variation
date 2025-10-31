<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить единицу измерения</x-slot>
    <x-slot name="text">Будет невозможно восстановить единицу измерения!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">{{ $unitId ? "Редактировать" : "Добавить" }} единицу измерения</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $unitId ? 'update' : 'store' }}" class="space-y-indent-half" id="unitDataForm">
            <div>
                <label for="title" class="inline-block mb-2">
                    Заголовок<span class="text-danger">*</span>
                </label>
                <input type="text" id="title"
                       class="form-control {{ $errors->has("title") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="title">
                <x-tt::form.error name="title"/>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="unitDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $unitId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>

<x-tt::modal.aside wire:model="displayList">
    <x-slot name="title">Список цен</x-slot>
    <x-slot name="content">
        @if ($variations && $variations->count())
            <ul class="space-y-indent-half">
                @foreach($variations as $variation)
                    <li class="flex flex-col space-y-1">
                        <span>{{ $variation->title }}</span>
                        <a href="{{ route('admin.products.show', ['product' => $variation->product]) }}"
                           target="_blank"
                           class="text-primary hover:text-primary-hover">
                            {{ $variation->product->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <div>Список пуст</div>
        @endif
    </x-slot>
</x-tt::modal.aside>
