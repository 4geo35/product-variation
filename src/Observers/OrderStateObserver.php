<?php

namespace GIS\ProductVariation\Observers;

use GIS\ProductVariation\Interfaces\OrderStateInterface;

class OrderStateObserver
{
    public function creating(OrderStateInterface $orderState): void
    {
        $orderState->fixKey();
    }

    public function updating(OrderStateInterface $orderState): void
    {
        $orderState->fixKey(true);
    }
}
