<x-admin-layout>
    <x-slot name="title">Заказ {{ $order->number }}</x-slot>
    <x-slot name="pageTitle">Заказ {{ $order->number }}</x-slot>

    <div class="row">
        <div class="col w-1/2">
            <livewire:pv-admin-manage-customer :order="$order" />
        </div>
    </div>
</x-admin-layout>
