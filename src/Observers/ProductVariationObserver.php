<?php

namespace GIS\ProductVariation\Observers;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\ProductVariation\Facades\ProductVariationActions;
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
        // Clear order items
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
    }
}
