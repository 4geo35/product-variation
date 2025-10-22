@if (config("variation-cart.enableCart"))
    {{-- TODO: add card button --}}
@else
    <livewire:pv-show-order-single-variation-button :$product />
@endif
