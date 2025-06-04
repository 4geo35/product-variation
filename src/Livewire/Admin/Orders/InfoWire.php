<?php

namespace GIS\ProductVariation\Livewire\Admin\Orders;

use GIS\ProductVariation\Interfaces\OrderInterface;
use GIS\ProductVariation\Traits\StateActions;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class InfoWire extends Component
{
    use StateActions;

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

    protected function resetFields(): void
    {
        $this->reset(["orderId", "stateId"]);
    }
}
