<?php

namespace GIS\ProductVariation\Observers;

use GIS\CategoryProduct\Facades\ProductActions;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\ProductVariation\Facades\ProductVariationActions;
use GIS\ProductVariation\Interfaces\OrderItemInterface;
use GIS\ProductVariation\Interfaces\ProductVariationInterface;

class ProductVariationObserver
{
    public function creating(ProductVariationInterface $variation): void
    {
        $variation->fixSku();
    }

    public function created(ProductVariationInterface $variation): void
    {
        $this->forgetPriceCache($variation);
    }

    public function updating(ProductVariationInterface $variation): void
    {
        $variation->fixSku();
    }

    public function updated(ProductVariationInterface $variation): void
    {
        if ($variation->wasChanged(["published_at", "sale", "price", "old_price"])) {
            $this->forgetPriceCache($variation);
        }
    }

    public function deleted(ProductVariationInterface $variation): void
    {
        $this->forgetPriceCache($variation);

        foreach ($variation->items as $item) {
            /**
             * @var OrderItemInterface $item
             */
            $item->variation()->disassociate();
            $item->save();
        }
    }

    protected function forgetPriceCache(ProductVariationInterface $variation): void
    {
        $product = $variation->product;
        /**
         * @var ProductInterface $product
         */
        $category = $product->category;
        /**
         * @var CategoryInterface $category
         */
        ProductVariationActions::forgetPricesForCategory($category);
        ProductActions::forgetTeaserData($product->id);
    }
}
