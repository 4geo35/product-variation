<?php

namespace GIS\ProductVariation\Http\Controllers\Admin;

use GIS\ProductVariation\Models\OrderState;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class OrderStateController
{
    public function index(): View
    {
        $stateModelClass = config("product-variation.customOrderStateModel") ?? OrderState::class;
        Gate::authorize("viewAny", $stateModelClass);
        return view("pv::admin.order-states.index");
    }
}
