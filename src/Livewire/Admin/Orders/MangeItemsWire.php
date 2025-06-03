<?php

namespace GIS\ProductVariation\Livewire\Admin\Orders;

use GIS\ProductVariation\Facades\OrderActions;
use GIS\ProductVariation\Interfaces\OrderInterface;
use GIS\ProductVariation\Interfaces\OrderItemInterface;
use GIS\ProductVariation\Models\OrderItem;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;

class MangeItemsWire extends Component
{
    public OrderInterface $order;

    public int|null $itemId = null;
    public int $quantity = 1;
    public bool $displayQuantity = false;

    public function updated($property, $value): void
    {
        if ($property === "quantity") {
            if ($value <= 0) $this->quantity = 1;
        }
    }

    public function render(): View
    {
        $items = $this->order->items()->with("product", "variation")->get();
        debugbar()->info($items);
        return view('pv::livewire.admin.orders.mange-items-wire', compact('items'));
    }

    public function closeQuantity(): void
    {
        $this->resetFields();
        $this->displayQuantity = false;
    }

    public function increaseQuantity(): void
    {
        $this->quantity++;
    }

    public function decreaseQuantity(): void
    {
        $this->quantity--;
    }

    public function showEditQuantity(int $itemId): void
    {
        $this->itemId = $itemId;
        $item = $this->findModel();
        if (! $item) { return; }
        if (! $this->checkAuth("update")) { return; }

        $this->quantity = $item->quantity;
        $this->displayQuantity = true;
    }

    public function updateQuantity(): void
    {
        $item = $this->findModel();
        if (! $item) { return; }
        if (! $this->checkAuth("update")) { return; }

        OrderActions::changeOrderItemQuantity($item, $this->quantity, false);
        OrderActions::recalculateOrderTotal($this->order);
        $this->order->fresh();
        $this->dispatch("order-updated");
        $this->closeQuantity();
        session()->flash("order-items-success", "Позиция заказа успешно обновлена");
    }

    protected function resetFields(): void
    {
        $this->reset(["itemId", "quantity"]);
    }

    protected function findModel(): ?OrderItemInterface
    {
        $itemModelClass = config("product-variation.customOrderItemModel") ?? OrderItem::class;
        $item = $itemModelClass::find($this->itemId);
        if (! $item) {
            session()->flash("order-items-error", "Позиция заказа не найдена");
            $this->closeQuantity();
            return null;
        }
        return $item;
    }

    protected function checkAuth(string $action): bool
    {
        try {
            $this->authorize($action, $this->order);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("order-customer-error", "Неавторизованное действие");
            $this->closeQuantity();
            return false;
        }
    }
}
