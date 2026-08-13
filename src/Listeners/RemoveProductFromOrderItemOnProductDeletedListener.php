<?php

namespace GIS\ProductVariation\Listeners;

use GIS\CategoryProduct\Events\ProductDeletedEvent;
use GIS\ProductVariation\Interfaces\OrderItemInterface;
use GIS\ProductVariation\Models\OrderItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class RemoveProductFromOrderItemOnProductDeletedListener implements ShouldQueue
{
    public function __construct() {}

    public function handle(ProductDeletedEvent $event): void
    {
        $modelClass = config("product-variation.customOrderItemModel") ?? OrderItem::class;
        $orderItems = $modelClass::query()
            ->where("product_id", "=", $event->productId)
            ->get();
        foreach ($orderItems as $orderItem) {
            /**
             * @var OrderItemInterface $orderItem
             */
            $orderItem->product()->dissociate();
            try {
                $orderItem->save();
            } catch (\Exception $e) { Log::error(self::class . " : " . $e->getMessage()); }
        }
    }
}
