<?php

namespace GIS\ProductVariation\Traits;

use GIS\ProductVariation\Interfaces\OrderStateInterface;
use GIS\ProductVariation\Models\OrderState;
use Illuminate\Database\Eloquent\Collection;

trait StateActions
{
    public bool $displayState = false;
    public int|null $orderId = null;
    public int|null $stateId = null;

    public Collection $orderStates;

    public function editStatus(int $orderId): void
    {
        $this->resetFields();
        $this->orderId = $orderId;
        if (empty($this->order)) { $order = $this->findOrder(); }
        else { $order = $this->order; }

        if (! $order) return;
        $this->displayState = true;
        $this->stateId = $order->state_id;
        $this->setStates();
    }

    public function closeState(): void
    {
        $this->displayState = false;
        $this->resetFields();
    }

    public function saveState(): void
    {
        if (empty($this->order)) { $order = $this->findOrder(); }
        else { $order = $this->order; }

        if (! $order) return;
        $state = $this->findState();
        if (! $state) return;
        $order->state()->associate($state);
        $order->save();
        session()->flash("success", "Статус изменен");
        $this->closeState();
    }

    protected function findState(): ?OrderStateInterface
    {
        $orderStateClass = config("product-variation.customOrderStateModel") ?? OrderState::class;
        $state = $orderStateClass::find($this->stateId);
        if (! $state) {
            session()->flash("error", "Статус не найден");
            $this->closeState();
            return null;
        }
        return $state;
    }

    protected function setStates(): void
    {
        $orderStateClass = config("product-variation.customOrderStateModel") ?? OrderState::class;
        $this->orderStates = $orderStateClass::query()
            ->select("id", "title")
            ->orderBy("title")
            ->get();
    }
}
