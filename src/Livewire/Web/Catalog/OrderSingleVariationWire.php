<?php

namespace GIS\ProductVariation\Livewire\Web\Catalog;

use GIS\ProductVariation\Facades\OrderActions;
use GIS\ProductVariation\Interfaces\OrderInterface;
use GIS\ProductVariation\Interfaces\ProductVariationInterface;
use GIS\ProductVariation\Models\Order;
use GIS\ProductVariation\Models\ProductVariation;
use GIS\ProductVariation\Traits\InitFirstVariation;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class OrderSingleVariationWire extends Component
{
    public int|null $variationId = null;
    public null|ProductVariationInterface $variation = null;

    public bool $displayData = false;

    public string $name = "";
    public string $email = "";
    public string $phone = "";
    public string $comment = "";
    public bool $policy = false;

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:150"],
            "email" => ["required_without:phone", "string", "email", "max:150"],
            "phone" => ["required_without:email", "string", "max:150"],
            "comment" => ["nullable", "string"],
            "policy" => ["required", "accepted"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "name" => "Имя",
            "email" => "E-mail",
            "phone" => "Телефон",
            "comment" => "Комментарий",
            "policy" => "Согласие с политикой конфиденциальности"
        ];
    }

    public function render(): View
    {
        return view('pv::livewire.web.catalog.order-single-variation-wire');
    }

    #[On("show-single-variation-modal")]
    public function showOrder(int $id): void
    {
        $this->variationId = $id;
        $this->findVariation();
        if (! $this->variation) { return; }
        $this->displayData = true;
    }

    public function closeOrder(): void
    {
        $this->displayData = false;
        $this->resetFields();
        $this->reset("variationId", "variation");
    }

    public function store(): void
    {
        $this->validate();
        $orderModelClass = config("product-variation.customOrderModel") ?? Order::class;
        $order = $orderModelClass::create([]);
        /**
         * @var OrderInterface $order
         */
        $this->addCustomerToOrder($order);
        OrderActions::addVariationsToOrder($order, [
            $this->variationId => (object) [
                "quantity" => 1,
            ]
        ]);
        $this->resetFields();
        session()->flash("single-order-success", "Ваш заказ № {$order->number} оформлен");
    }

    protected function resetFields(): void
    {
        $this->reset("name", "phone", "email", "comment", "policy");
    }

    protected function addCustomerToOrder(OrderInterface $order): void
    {
        $order->customer()->create([
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "comment" => $this->comment,
        ]);
    }

    protected function findVariation(): void
    {
        try {
            $modelClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
            $this->variation = $modelClass::where("id", $this->variationId)->with("product")->first();
        } catch (\Exception $exception) {
            $this->variation = null;
        }
    }
}
