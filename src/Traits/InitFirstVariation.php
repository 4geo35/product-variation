<?php

namespace GIS\ProductVariation\Traits;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\ProductVariation\Interfaces\ProductVariationInterface;
use Illuminate\Database\Eloquent\Collection;

trait InitFirstVariation
{
    public ProductInterface $product;
    public Collection $variations;
    public ProductVariationInterface|null $variation = null;
    public int|null $variationId = null;

    protected function setFirstVariation(): void
    {
        $this->variations = $this->product->orderedVariations()->with("unit:id,title")->get();
        if ($this->variations->count() > 0) {
            $this->variation = $this->variations->first();
            $this->variationId = $this->variation->id;
        }
    }
}
