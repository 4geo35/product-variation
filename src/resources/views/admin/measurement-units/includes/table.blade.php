<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">Заголовок</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Вариации</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>

    <x-slot name="body">
        @foreach($units as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>
                    @if ($item->variations->count())
                        <button type="button" class="text-primary hover:text-primary-hover cursor-pointer"
                                wire:click="showList({{ $item->id }})">
                            Список ({{ $item->variations->count() }})
                        </button>
                    @else
                        <span class="text-nowrap">Нет привязанных цен</span>
                    @endif
                </td>
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
