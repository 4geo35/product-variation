<?php

namespace GIS\ProductVariation\Listeners;

use GIS\ProductVariation\Events\VariationDeletedEvent;
use GIS\ProductVariation\Interfaces\OrderItemInterface;
use GIS\ProductVariation\Models\OrderItem;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveVariationFromOrderItemListener implements ShouldQueue
{
    public function __construct() {}

    public function handle(VariationDeletedEvent $event): void
    {
        $modelClass = config("product-variation.customOrderItemModel") ?? OrderItem::class;
        $orderItems = $modelClass::query()
            ->where("variation_id", "=", $event->variationId)
            ->get();
        foreach ($orderItems as $orderItem) {
            /**
             * @var OrderItemInterface $orderItem
             */
            $orderItem->variation()->dissociate();
            $orderItem->save();
        }
    }
}
