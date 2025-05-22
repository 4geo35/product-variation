<div class="card">
    <div class="card-body">
        <div class="space-y-indent-half">
            @include("pv::admin.orders.includes.search")
            <x-tt::notifications.error />
            <x-tt::notifications.success />
        </div>
    </div>
    @include("pv::admin.orders.includes.table")
    @include("pv::admin.orders.includes.table-modals")
</div>
