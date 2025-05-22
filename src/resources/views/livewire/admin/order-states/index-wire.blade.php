<div class="card">
    <div class="card-body">
        <div class="space-y-indent-half">
            @include("pv::admin.order-states.includes.search")
            <x-tt::notifications.error prefix="state-" />
            <x-tt::notifications.success prefix="state-" />
        </div>
    </div>
    @include("pv::admin.order-states.includes.table")
    @include("pv::admin.order-states.includes.table-modals")
</div>
