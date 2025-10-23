@php($key = "product-variation-button-{$product->id}-" . now()->timestamp)
@if (config("variation-cart.enableCart"))
    <livewire:vc-add-variation-to-cart :$product wire:key="{{ $key }}" />
@else
    <livewire:pv-show-order-single-variation-button :$product wire:key="{{ $key }}" />
@endif
