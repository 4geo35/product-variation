<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить позицию заказа</x-slot>
    <x-slot name="text">Будет невозможно восстановить позицию заказа</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayProducts">
    <x-slot name="title">Добавить позицию</x-slot>
    <x-slot name="content">
        <div class="space-y-indent">
            @if (! $chosenVariation)
                <div class="flex items-center">
                    <input type="text" class="form-control rounded-e-none" placeholder="Товар" aria-label="Товар" wire:model.live.400="searchProduct">
                    <button type="button" class="btn btn-dark rounded-s-none" wire:click="searchProduct = ''">
                        <x-tt::ico.cross />
                    </button>
                </div>
            @else
                <div class="space-y-indent-half">
                    <div class="font-semibold">Добавить {{ $chosenVariation->sku }}:{{ $chosenVariation->human_price }}?</div>
                    <div class="flex items-center justify-start">
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-e-none border-e-0"
                                wire:click="decreaseQuantity"
                                @if ($quantity <= 1) disabled @endif>
                            <x-vc::ico.minus />
                        </button>
                        <input type="number" aria-label="Количество"
                               class="form-control form-control-sm border-secondary text-center rounded-none max-w-24 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                               wire:model.blur="quantity" min="1">
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-s-none border-s-0"
                                wire:click="increaseQuantity">
                            <x-vc::ico.plus />
                        </button>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="button" class="btn btn-sm btn-outline-dark" wire:click="cancelChose">Отменить</button>
                        <button type="button" class="btn btn-sm btn-primary" wire:click="confirmChose">Подтвердить</button>
                    </div>
                </div>
            @endif

            <x-tt::notifications.error prefix="choose-product-" />
            <x-tt::notifications.success prefix="choose-product-" />

            @if (! $chosenVariation)
                <div class="space-y-indent-half">
                    @if (! empty($productList))
                        @foreach($productList as $product)
                            <div class="space-y-2">
                                <div class="text-lg font-semibold">{{ $product->title }}</div>
                                @foreach($product->variations as $item)
                                    <div class="flex justify-between items-center flex-nowrap">
                                        <div class="">
                                            <div>{{ ! empty($item->title) ? $item->title : $item->sku }}</div>
                                            <div class="text-nowrap font-semibold">{{ $item->human_price }} руб</div>
                                        </div>
                                        <button type="button" class="btn btn-outline-dark btn-sm"
                                                wire:click="chooseVariation({{ $item->id }})">
                                            Выбрать
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
    </x-slot>
</x-tt::modal.aside>
