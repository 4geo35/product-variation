<div class="card">
    <div class="card-header">
        <div class="space-y-indent-half">
            @include("pv::admin.order-items.includes.show-title")
            <x-tt::notifications.error prefix="order-items-" />
            <x-tt::notifications.success prefix="order-items-" />
        </div>
    </div>

    @include("pv::admin.order-items.includes.table")
    @include("pv::admin.order-items.includes.table-modals")
</div>
