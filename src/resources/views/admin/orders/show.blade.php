<x-admin-layout>
    <x-slot name="title">Заказ {{ $order->number }}</x-slot>
    <x-slot name="pageTitle">Заказ {{ $order->number }}</x-slot>

    <div class="flex flex-col gap-y-indent">
        <div class="row">
            <div class="col w-1/2">
                <livewire:pv-admin-manage-customer :order="$order" />
            </div>
            <div class="col w-1/2">
                <livewire:pv-admin-order-info :order="$order" />
            </div>
        </div>

        <livewire:pv-admin-manage-items :order="$order" />
    </div>
</x-admin-layout>
