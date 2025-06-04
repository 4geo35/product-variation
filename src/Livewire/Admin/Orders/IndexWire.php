<?php

namespace GIS\ProductVariation\Livewire\Admin\Orders;

use GIS\ProductVariation\Interfaces\OrderInterface;
use GIS\ProductVariation\Interfaces\OrderStateInterface;
use GIS\ProductVariation\Models\Order;
use GIS\ProductVariation\Models\OrderState;
use GIS\ProductVariation\Traits\StateActions;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class IndexWire extends Component
{
    use WithPagination, StateActions;

    public string $searchNumber = "";
    public string $searchEmail = "";
    public string $searchPhone = "";

    public bool $displayDelete = false;


    public function mount(): void
    {
        $this->setStates();
    }

    protected function queryString(): array
    {
        return [
            "searchNumber" => ["as" => "number", "except" => ""],
            "searchEmail" => ["as" => "email", "except" => ""],
            "searchPhone" => ["as" => "phone", "except" => ""],
        ];
    }

    public function render(): View
    {
        $orderModelClass = config("product-variation.customOrderModel") ?? Order::class;
        $query = $orderModelClass::query()
            ->leftJoin("order_customers", "orders.id", "=", "order_customers.order_id")
            ->select("orders.*")
            ->with("state", "customer");
        BuilderActions::extendLike($query, $this->searchNumber, "orders.number");
        BuilderActions::extendLike($query, $this->searchEmail, "order_customers.email");
        BuilderActions::extendLike($query, $this->searchPhone, "order_customers.phone");
        $query->orderBy("orders.created_at", "desc");
        $orders = $query->paginate();

        return view('pv::livewire.admin.orders.index-wire', compact("orders"));
    }

    public function clearSearch(): void
    {
        $this->reset("searchNumber", "searchEmail", "searchPhone");
        $this->resetPage();
    }

    public function showDelete(int $orderId): void
    {
        $this->resetFields();
        $this->orderId = $orderId;
        $order = $this->findOrder();
        if (! $order) return;
        $this->displayDelete = true;
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function confirmDelete(): void
    {
        $order = $this->findOrder();
        if (! $order) return;
        $order->delete();
        session()->flash("success", "Заказ успешно удален");
        $this->resetPage();
        $this->closeDelete();
    }

    protected function findOrder(): ?OrderInterface
    {
        $orderModelClass = config("product-variation.customOrderModel") ?? Order::class;
        $order = $orderModelClass::find($this->orderId);
        if (! $order) {
            session()->flash("error", "Заказ не найден");
            $this->closeDelete();
            $this->closeState();
            return null;
        }
        return $order;
    }

    protected function resetFields(): void
    {
        $this->reset(["orderId", "stateId"]);
    }
}
