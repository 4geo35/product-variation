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
                        <span class="font-semibold">{{ $item->title }}</span>
                        @if ($item->product)
                            <a href="{{ route("admin.products.show", ["product" => $item->product]) }}"
                               target="_blank"
                               class="text-primary hover:text-primary-hover">
                                <x-tt::ico.eye />
                            </a>
                        @endif
                    </div>
                </td>
                <td>{{ $item->sku }}</td>
                <td>{{ $item->human_price }} руб.</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->human_total }} руб.</td>
                <td></td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
