<?php

namespace GIS\ProductVariation\Observers;

use GIS\ProductVariation\Events\ChangeOrderStateEvent;
use GIS\ProductVariation\Events\CreateNewOrderEvent;
use GIS\ProductVariation\Facades\OrderActions;
use GIS\ProductVariation\Interfaces\OrderInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderObserver
{
    public function creating(OrderInterface $order): void
    {
        $order->number = OrderActions::generateUniqueNumber(
            config("product-variation.orderNumberHasLetter"),
            config("product-variation.orderDigitsLength")
        );
        $order->uuid = Str::uuid();
        if (Auth::check()) { $order->user_id = Auth::id(); }
        $order->ip = request()->ip();
        $this->addState($order);
    }

    public function created(OrderInterface $order): void
    {
        CreateNewOrderEvent::dispatch($order);
    }

    public function updated(OrderInterface $order): void
    {
        if ($order->wasChanged("state_id")) {
            ChangeOrderStateEvent::dispatch($order);
        }
    }

    public function deleted(OrderInterface $order): void
    {
        $customer = $order->customer;
        if (! empty($customer)) { $customer->delete(); }
        foreach ($order->items as $item) {
            $item->delete();
        }
    }

    protected function addState(OrderInterface $order): void
    {
        if (empty($order->state_id)) {
            $state = OrderActions::getNewState();
            $order->state_id = $state->id;
        }
    }
}
