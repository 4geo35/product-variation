<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">Номер</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Контакты</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Комментарий</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Товары</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Сумма</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Статус</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>

    <x-slot name="body">
        @foreach($orders as $item)
            <tr>
                <td>{{ $item->number }}</td>
                @if ($item->customer)
                    <td>
                        <ul class="space-y-indent-half">
                            <li>Имя: {{ $item->customer->name }}</li>
                            @if ($item->customer->phone)
                                <li>Телефон: <a href="tel:{{ $item->customer->phone }}" class="hover:text-primary-hover">{{ $item->customer->phone }}</a></li>
                            @endif
                            @if ($item->customer->email)
                                <li>Email: <a href="mailto:{{ $item->customer->email }}" class="hover:text-primary-hover">{{ $item->customer->email }}</a></li>
                            @endif
                        </ul>
                    </td>
                    <td>{{ $item->customer->comment }}</td>
                @else
                    <td colspan="2">Не найдены данные пользователя</td>
                @endif
                <td>
                    <ul class="space-y-indent-half">
                        @foreach($item->items as $orderItem)
                            <li class="text-nowrap">
                                <span class="font-semibold">{{ $orderItem->title }}:</span>
                                <br>
                                {{ $orderItem->variation_title }} {{ $orderItem->human_price }} руб.
                                <span class="font-semibold">x</span>
                                {{ $orderItem->quantity }} ({{ $orderItem->human_total }} руб.)
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $item->human_total }} руб.</td>
                <td>
                    @if ($displayState && $orderId === $item->id)
                        <div class="flex items-center justify-start space-x-1">
                            <select class="form-select form-select-sm" aria-label="Статус" wire:model.live="stateId">
                                @foreach($orderStates as $state)
                                    <option value="{{ $state->id }}">{{ $state->title }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-sm px-btn-x-ico btn-outline-secondary" wire:click="closeState">
                                <x-tt::ico.cross />
                            </button>
                            <button type="button" class="btn btn-sm px-btn-x-ico btn-outline-success" wire:click="saveState">ОК</button>
                        </div>
                    @else
                        <button type="button" class="text-primary hover:text-primary-hover" wire:click="editStatus({{ $item->id }})">
                            {{ $item->state->title }}
                        </button>
                    @endif
                </td>
                <td>
                    <div class="flex justify-center">
                        <button type="button" class="btn btn-danger px-btn-x-ico"
                                wire:loading.attr="disabled"
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash />
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>

    <x-slot name="caption">
        <div class="flex justify-between">
            <div>{{ __("Total") }}: {{ $orders->total() }}</div>
            {{ $orders->links("tt::pagination.live") }}
        </div>
    </x-slot>
</x-tt::table>
