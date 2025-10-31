<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">
                <span class="text-nowrap">SKU</span>
            </x-tt::table.heading>
            <x-tt::table.heading class="text-left">
                <span class="text-nowrap">Заголовок</span>
            </x-tt::table.heading>
            <x-tt::table.heading class="text-left">
                <span class="text-nowrap">Ед. изм.</span>
            </x-tt::table.heading>
            <x-tt::table.heading class="text-left">
                <span class="text-nowrap">Цена</span>
            </x-tt::table.heading>
            <x-tt::table.heading class="text-left">
                <span class="text-nowrap">Цена без скидки</span>
            </x-tt::table.heading>
            <x-tt::table.heading class="text-left">
                <span class="text-nowrap">Скидка</span>
            </x-tt::table.heading>
            <x-tt::table.heading class="text-left">
                <span class="text-nowrap">Мин. заказ</span>
            </x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($variations as $item)
            <tr>
                <td>{{ $item->sku }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->unit_id ? $item->unit->title : config("product-variation.defaultMeasurement") }}</td>
                <td>{{ $item->human_price }}</td>
                <td>{{ $item->human_old_price }}</td>
                <td>{{ $item->sale ? "Активна" : "Неактивна" }}</td>
                <td>{{ $item->minimal_order ?? "-" }}</td>
                <td>
                    <div class="flex justify-center">
                        <button type="button" class="btn btn-dark px-btn-x-ico rounded-e-none"
                                wire:loading.attr="disabled"
                                wire:click="showEdit({{ $item->id }})">
                            <x-tt::ico.edit />
                        </button>
                        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                                wire:loading.attr="disabled"
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash />
                        </button>

                        <button type="button" class="btn {{ $item->published_at ? 'btn-success' : 'btn-danger' }} px-btn-x-ico ml-indent-half"
                                wire:loading.attr="disabled"
                                wire:click="switchPublish({{ $item->id }})">
                            @if ($item->published_at)
                                <x-tt::ico.toggle-on />
                            @else
                                <x-tt::ico.toggle-off />
                            @endif
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
