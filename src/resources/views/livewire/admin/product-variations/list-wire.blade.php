<div class="card">
    <div class="card-header">
        <div class="space-y-indent-half">
            @include("pv::admin.product-variations.includes.title")
            <x-tt::notifications.error prefix="variation-" />
            <x-tt::notifications.success prefix="variation-" />
        </div>
    </div>

    @include("pv::admin.product-variations.includes.table")
    @include("pv::admin.product-variations.includes.table-modals")
</div>
