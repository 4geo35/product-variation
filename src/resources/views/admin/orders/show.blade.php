<x-admin-layout>
    <x-slot name="title">Заказ {{ $order->number }}</x-slot>
    <x-slot name="pageTitle">Заказ {{ $order->number }}</x-slot>

    <div class="flex flex-col gap-y-indent">
        <div class="row gap-y-indent lg:gap-y-0">
            <div class="col w-full lg:w-1/2 h-full order-last lg:order-first">
                <livewire:pv-admin-manage-customer :order="$order" />
            </div>
            <div class="col w-full lg:w-1/2 h-full">
                <livewire:pv-admin-order-info :order="$order" />
            </div>
        </div>

        <livewire:pv-admin-manage-items :order="$order" />
    </div>
</x-admin-layout>
