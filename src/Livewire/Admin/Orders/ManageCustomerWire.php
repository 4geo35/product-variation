<?php

namespace GIS\ProductVariation\Livewire\Admin\Orders;

use GIS\ProductVariation\Interfaces\OrderCustomerInterface;
use GIS\ProductVariation\Interfaces\OrderInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;

class ManageCustomerWire extends Component
{
    public OrderInterface $order;
    public OrderCustomerInterface|null $customer;

    public bool $displayData = false;
    public string $name = "";
    public string $email = "";
    public string $phone = "";
    public string $comment = "";

    public function mount(): void
    {
        $this->customer = $this->order->customer;
    }

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:150"],
            "email" => ["required_without:phone", "string", "email", "max:150"],
            "phone" => ["required_without:email", "string", "max:150"],
            "comment" => ["nullable", "string"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "name" => "Имя",
            "email" => "E-mail",
            "phone" => "Телефон",
            "comment" => "Комментарий",
        ];
    }

    public function render(): View
    {
        return view("pv::livewire.admin.orders.manage-customer-wire");
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showEdit(): void
    {
        $this->resetFields();
        if (! $this->checkAuth("update")) { return; }

        $this->name = $this->customer->name;
        $this->email = $this->customer->email;
        $this->phone = $this->customer->phone;
        $this->comment = $this->customer->comment;
        $this->displayData = true;
    }

    public function update(): void
    {
        if (! $this->checkAuth("update")) { return; }
        $this->validate();

        $this->customer->update([
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "comment" => $this->comment,
        ]);

        session()->flash("order-customer-success", "Данные покупателя успешно обновлены");
        $this->closeData();
        $this->customer->fresh();
        $this->order->fresh();
    }

    protected function resetFields(): void
    {
        $this->reset(["name", "email", "phone", "comment"]);
    }

    protected function checkAuth(string $action): bool
    {
        try {
            $this->authorize($action, $this->order);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("order-customer-error", "Неавторизованное действие");
            $this->closeData();
            return false;
        }
    }
}
