<div class="mt-indent">
    <livewire:pv-choose-variation :product="$product" />
    <div class="flex mt-indent-half space-x-indent-half">
        @includeIf("pf::web.favorite.btn-switcher")
        @include("pv::web.variations.variation-button")
    </div>
</div>
