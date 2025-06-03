<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">Товар</x-tt::table.heading>
            <x-tt::table.heading class="text-left">SKU</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Цена</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Количество</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Итого</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($items as $item)
            <tr>
                <td>
                    <div class="flex items-center justify-start space-x-2">
                        <span class="font-semibold text-nowrap">{{ $item->title }}</span>
                        @if ($item->product)
                            <a href="{{ route("admin.products.show", ["product" => $item->product]) }}"
                               target="_blank"
                               class="text-primary hover:text-primary-hover">
                                <x-tt::ico.eye />
                            </a>
                        @endif
                    </div>
                </td>
                <td><span class="text-nowrap">{{ $item->sku }}</span></td>
                <td><span class="text-nowrap">{{ $item->human_price }} руб.</span></td>
                <td>
                    @if ($displayQuantity && $itemId === $item->id)
                        <div class="flex items-center space-x-indent-half">
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
                            <div class="flex items-center">
                                <button type="button" class="btn btn-success btn-sm rounded-e-none"
                                        wire:click="updateQuantity">
                                    OK
                                </button>
                                <button type="button" class="btn btn-dark btn-sm rounded-s-none"
                                        wire:click="closeQuantity">
                                    <x-tt::ico.cross />
                                </button>
                            </div>
                        </div>
                    @else
                        <button type="button" wire:click="showEditQuantity({{ $item->id }})"
                                class="cursor-pointer text-primary hover:text-primary-hover">
                            {{ $item->quantity }}
                        </button>
                    @endif
                </td>
                <td><span class="text-nowrap">{{ $item->human_total }} руб.</span></td>
                <td></td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
