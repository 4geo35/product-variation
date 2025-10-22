<div class="mt-indent">
    <livewire:pv-choose-variation :product="$product" />
    <div class="flex mt-indent-half">
        {{-- TODO: add favorite --}}
        @include("pv::web.variations.variation-button")
    </div>
</div>
