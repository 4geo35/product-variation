<?php

namespace GIS\ProductVariation\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\ProductVariation\Models\MeasurementUnit;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class UnitController extends Controller
{
    public function index(): View
    {
        $unitModelClass = config("product-variation.customUnitModel") ?? MeasurementUnit::class;
        Gate::authorize("viewAny", $unitModelClass);
        return view("pv::admin.measurement-units.index");
    }
}
