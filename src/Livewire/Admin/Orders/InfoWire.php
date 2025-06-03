<?php

namespace GIS\ProductVariation\Livewire\Admin\Orders;

use GIS\ProductVariation\Interfaces\OrderInterface;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class InfoWire extends Component
{
    public OrderInterface $order;

    public string|null $updatedTime = null;

    public function mount(): void
    {
        $this->updatedTime = now()->timestamp;
    }

    public function render(): View
    {
        $time = $this->updatedTime;
        return view("pv::livewire.admin.orders.info-wire", compact("time"));
    }

    #[On("order-updated")]
    public function freshOrder(): void
    {
        $this->order->fresh();
        $this->updatedTime = now()->timestamp;
    }
}
