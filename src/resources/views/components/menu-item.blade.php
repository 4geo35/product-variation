@php
    $stateActive = in_array(Route::currentRouteName(), [
        "admin.order-states.index",
    ]);
    $canViewStates = \Illuminate\Support\Facades\Auth::user()
        ->can(
            "viewAny",
            config("product-variation.customOrderStateModel") ?? \GIS\ProductVariation\Models\OrderState::class
        );

    $orderActive = in_array(Route::currentRouteName(), [
        "admin.orders.index", "admin.orders.show",
    ]);
    $canViewOrders = \Illuminate\Support\Facades\Auth::user()
        ->can(
            "viewAny",
            config("product-variation.customOrderModel") ?? \GIS\ProductVariation\Models\Order::class
        );
@endphp

@if ($canViewOrders || $canViewStates)
    <x-tt::admin-menu.item href="#" :active="$stateActive || $orderActive">
        <x-slot name="ico"><x-pv::ico.shopping-basket /></x-slot>
        Заказы
        <x-slot name="children">
            @if ($canViewOrders)
                <x-tt::admin-menu.child href="{{ route('admin.orders.index') }}" :active="$orderActive">
                    Список
                </x-tt::admin-menu.child>
            @endif
            @if ($canViewStates)
                <x-tt::admin-menu.child href="{{ route('admin.order-states.index') }}" :active="$stateActive">
                    Статусы
                </x-tt::admin-menu.child>
            @endif
        </x-slot>
    </x-tt::admin-menu.item>
@endif
