<?php

namespace GIS\ProductVariation\Observers;

use GIS\ProductVariation\Interfaces\OrderItemInterface;

class OrderItemObserver
{
    public function creating(OrderItemInterface $item): void
    {
        $product = $item->product;
        $item->title = $product->title;

        $variation = $item->variation;
        $item->variation_title = $variation->title;
    }
}
