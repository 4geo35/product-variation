<?php

namespace GIS\ProductVariation\Observers;

use GIS\CategoryProduct\Facades\ProductActions;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\ProductVariation\Events\VariationDeletedEvent;
use GIS\ProductVariation\Events\VariationPriceChangedEvent;
use GIS\ProductVariation\Events\VariationUnpublishedEvent;
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
        $variation->fixSku(true);
    }

    public function updated(ProductVariationInterface $variation): void
    {
        if ($variation->wasChanged(["published_at", "price", "sale", "old_price"])) {
            $this->forgetPriceCache($variation);
        }
        if ($variation->wasChanged("published_at") && ! $variation->published_at) {
            VariationUnpublishedEvent::dispatch($variation);
        }
        if ($variation->wasChanged(["price", "sale", "old_price"])) {
            VariationPriceChangedEvent::dispatch($variation);
        }
    }

    public function deleted(ProductVariationInterface $variation): void
    {
        $this->forgetPriceCache($variation);
        VariationDeletedEvent::dispatch($variation->id);
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
