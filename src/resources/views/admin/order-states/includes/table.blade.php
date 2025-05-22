<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">Заголовок</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Адресная строка</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Ключ</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Заказы</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>

    <x-slot name="body">
        @foreach($states as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->slug }}</td>
                <td>{{ $item->key }}</td>
                <td>{{ $item->orders->count() }}</td>
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
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
