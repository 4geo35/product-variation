<div class="mt-indent">
    <livewire:pv-choose-variation :product="$product" />
    @if (config("variation-cart.enableCart"))
        @includeIf("vc::web.cart.add-button")
    @else
        <livewire:pv-order-single-variation :product="$product" />
    @endif
</div>
