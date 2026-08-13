<?php

namespace GIS\ProductVariation\Listeners;

use GIS\CategoryProduct\Events\ProductDeletedEvent;
use GIS\ProductVariation\Interfaces\ProductVariationInterface;
use GIS\ProductVariation\Models\ProductVariation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class DeleteProductVariationsOnProductDeletedListener implements ShouldQueue
{
    public function __construct() {}

    public function handle(ProductDeletedEvent $event): void
    {
        $modelClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
        $variations = $modelClass::query()
            ->where("product_id", "=", $event->productId)
            ->get();
        foreach ($variations as $variation) {
            /**
             * @var ProductVariationInterface $variation
             */
            try {
                $variation->delete();
            } catch (\Exception $e) { Log::error(self::class . " : " . $e->getMessage()); }
        }
    }
}
