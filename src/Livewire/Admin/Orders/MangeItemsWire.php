<?php

namespace GIS\ProductVariation\Livewire\Admin\Orders;

use GIS\CategoryProduct\Models\Product;
use GIS\ProductVariation\Facades\OrderActions;
use GIS\ProductVariation\Interfaces\OrderInterface;
use GIS\ProductVariation\Interfaces\OrderItemInterface;
use GIS\ProductVariation\Interfaces\ProductVariationInterface;
use GIS\ProductVariation\Models\OrderItem;
use GIS\ProductVariation\Models\ProductVariation;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class MangeItemsWire extends Component
{
    public OrderInterface $order;

    public int|null $itemId = null;
    public int $quantity = 1;
    public bool $displayQuantity = false;
    public bool $displayDelete = false;
    public bool $displayProducts = false;

    public Collection|null $productList = null;
    public string $searchProduct = "";
    public ProductVariationInterface|null $chosenVariation = null;

    public function updated($property, $value): void
    {
        if ($property === "quantity") {
            if ($value <= 0) $this->quantity = 1;
        } elseif ($property === "searchProduct") {
            $this->setProductList();
        }
    }

    public function render(): View
    {
        $items = $this->order->items()->with("product", "variation")->get();
        return view('pv::livewire.admin.orders.mange-items-wire', compact('items'));
    }

    public function closeQuantity(): void
    {
        $this->resetFields();
        $this->displayQuantity = false;
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

    public function increaseQuantity(): void
    {
        $this->quantity++;
    }

    public function decreaseQuantity(): void
    {
        $this->quantity--;
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

    public function closeProducts(): void
    {
        $this->displayProducts = false;
        $this->resetFields();
    }

    public function showProducts(): void
    {
        if (! $this->checkAuth("update")) { return; }
        $this->resetFields();
        $this->displayProducts = true;
    }

    public function chooseVariation(int $variationId): void
    {
        $variation = $this->findVariation($variationId);
        if (! $variation) { return; }
        $this->chosenVariation = $variation;
    }

    public function cancelChose(): void
    {
        $this->reset("chosenVariation");
    }

    public function confirmChose(): void
    {
        if (! $this->checkAuth("update")) { return; }
        OrderActions::addVariationsToOrder($this->order, [
            $this->chosenVariation->id => (object) [
                "quantity" => $this->quantity,
                "price" => $this->chosenVariation->price,
            ],
        ]);
        $this->cancelChose();
        session()->flash("choose-product-success", "Вариация успешно добавлена к заказу");
        $this->dispatch("order-updated");
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function showDelete(int $itemId): void
    {
        $this->itemId = $itemId;
        $item = $this->findModel();
        if (! $item) { return; }
        if (! $this->checkAuth("update")) { return; }

        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $item = $this->findModel();
        if (! $item) { return; }
        if (! $this->checkAuth("update")) { return; }

        try {
            $item->delete();
            session()->flash("order-items-success", "Позиция заказа успешно удалена");
            OrderActions::recalculateOrderTotal($this->order);
            $this->order->fresh();
            $this->dispatch("order-updated");
        } catch (\Exception $exception) {
            session()->flash("order-items-error", "Ошибка при удалении позиции заказа");
        }

        $this->closeDelete();
    }

    protected function resetFields(): void
    {
        $this->reset(["itemId", "quantity", "searchProduct", "chosenVariation", "productList"]);
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

    protected function findVariation(int $id): ?ProductVariationInterface
    {
        $variationModelClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
        $variation = $variationModelClass::find($id);
        if (! $variation) {
            $this->setProductList();
            session()->flash("choose-product-error", "Вариация товара не найдена");
            return null;
        }
        return $variation;
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

    protected function setProductList(): void
    {
        if (empty($this->searchProduct)) {
            $this->reset("productList");
            return;
        }
        $productModelClass = config("category-product.customProductModel") ?? Product::class;
        $query = $productModelClass::query()
            ->select("id", "title")
            ->with("variations");
        BuilderActions::extendLike($query, $this->searchProduct, "title");
        $this->productList = $query->orderBy("title")->get();
    }
}
