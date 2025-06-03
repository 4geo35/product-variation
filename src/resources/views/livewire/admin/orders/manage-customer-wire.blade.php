<div class="card">
    <div class="card-header">
        <div class="space-y-indent-half">
            @include("pv::admin.order-customers.includes.show-title")
            <x-tt::notifications.error prefix="order-customer-" />
            <x-tt::notifications.success prefix="order-customer-" />
        </div>
    </div>
    <div class="card-body">
        @include("pv::admin.order-customers.includes.show-info")
    </div>

    @include("pv::admin.order-customers.includes.modals")
</div>
