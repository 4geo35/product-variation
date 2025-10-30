<div class="card">
    <div class="card-body">
        <div class="space-y-indent-half">
            @include("pv::admin.measurement-units.includes.search")
            <x-tt::notifications.error prefix="unit-" />
            <x-tt::notifications.success prefix="unit-" />
        </div>
    </div>
    @include("pv::admin.measurement-units.includes.table")
    @include("pv::admin.measurement-units.includes.table-modals")
</div>
