<?php

namespace GIS\ProductVariation\Models;

use GIS\CategoryProduct\Models\Product;
use GIS\ProductVariation\Interfaces\ProductVariationInterface;
use GIS\TraitsHelpers\Traits\ShouldHumanDate;
use GIS\TraitsHelpers\Traits\ShouldHumanPublishDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariation extends Model implements ProductVariationInterface
{
    use ShouldHumanDate, ShouldHumanPublishDate;

    protected $fillable = [
        "sku",
        "price",
        "old_price",
        "sale",
        "published_at",
        "title"
    ];

    public function product(): BelongsTo
    {
        $productModelClass = config("category-product.customProductModel") ?? Product::class;
        return $this->belongsTo($productModelClass, "product_id");
    }

    public function fixSku(bool $updating = false): void
    {
        if ($updating && ($this->original["sku"] == $this->sku)) { return; }

        if (empty($this->sku)) {
            $product = $this->product;
            $category = $product->category;
            $sku = "{$category->slug}#{$product->slug}";
        } else {
            $sku = $this->sku;
        }

        $sku = str_replace(" ", "#", $sku);
        $buf = $sku;
        $i = 1;
        if ($updating) $id = $this->id;
        else $id = 0;
        $variationModelClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
        while (
            $variationModelClass::query()
                ->select("id")
                ->where("sku", $buf)
                ->where("id", "!=", $id)
                ->count()
        ) {
            $buf = $sku . "-" . $i++;
        }
        $this->sku = $buf;
    }
}
