<?php

namespace GIS\ProductVariation\Livewire\Admin\Orders;

use GIS\ProductVariation\Interfaces\OrderInterface;
use Illuminate\View\View;
use Livewire\Component;

class MangeItemsWire extends Component
{
    public OrderInterface $order;

    public function render(): View
    {
        $items = $this->order->items()->with("product", "variation")->get();
        debugbar()->info($items);
        return view('pv::livewire.admin.orders.mange-items-wire', compact('items'));
    }
}
