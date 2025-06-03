<?php

namespace GIS\ProductVariation\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\ProductVariation\Interfaces\OrderInterface;
use GIS\ProductVariation\Models\Order;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orderModelClass = config("product-variation.customOrderModel") ?? Order::class;
        Gate::authorize("viewAny", $orderModelClass);
        return view("pv::admin.orders.index");
    }

    public function show(OrderInterface $order): View
    {
        $orderModelClass = config("product-variation.customOrderModel") ?? Order::class;
        Gate::authorize("viewAny", $orderModelClass);
        return view("pv::admin.orders.show", compact("order"));
    }
}
