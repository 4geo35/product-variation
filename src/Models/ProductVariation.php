<?php

namespace GIS\ProductVariation\Models;

use GIS\VariationCart\Models\Cart;
use GIS\CategoryProduct\Models\Product;
use GIS\ProductVariation\Interfaces\ProductVariationInterface;
use GIS\TraitsHelpers\Traits\ShouldHumanDate;
use GIS\TraitsHelpers\Traits\ShouldHumanPublishDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariation extends Model implements ProductVariationInterface
{
    use ShouldHumanDate, ShouldHumanPublishDate;

    protected $fillable = [
        "sku",
        "price",
        "old_price",
        "sale",
        "published_at",
        "title",
        "unit_id",
    ];

    public function product(): BelongsTo
    {
        $productModelClass = config("category-product.customProductModel") ?? Product::class;
        return $this->belongsTo($productModelClass, "product_id");
    }

    public function unit(): BelongsTo
    {
        $modelClass = config("product-variation.customUnitModel") ?? MeasurementUnit::class;
        return $this->belongsTo($modelClass, "unit_id");
    }

    public function items(): HasMany
    {
        $orderItemModelClass = config("product-variation.customOrderItemModel") ?? OrderItem::class;
        return $this->hasMany($orderItemModelClass, "variation_id");
    }

    public function carts(): BelongsToMany
    {
        if (config("variation-cart")) {
            $cartModelClass = config("variation-cart.customCartModel") ?? Cart::class;
            return $this->belongsToMany($cartModelClass)
                ->withPivot("quantity")
                ->withTimestamps();
        } else {
            return new BelongsToMany($this->newQuery(), $this, "", "", "", "", "");
        }
    }

    public function getHumanPriceAttribute(): string
    {
        if ($this->price - intval($this->price) > 0)
            return number_format($this->price, 2, ",", " ");
        else
            return number_format($this->price, 0, ",", " ");
    }

    public function getHumanOldPriceAttribute(): string
    {
        if ($this->old_price - intval($this->old_price) > 0)
            return number_format($this->old_price ?? 0, 2, ",", " ");
        else
            return number_format($this->old_price ?? 0, 0, ",", " ");
    }

    public function getDiscountAttribute(): mixed
    {
        if ($this->sale)
            return $this->old_price - $this->price;
        else
            return 0;
    }

    public function getHumanDiscountAttribute(): string
    {
        if ($this->discount - intval($this->discount) > 0)
            return number_format($this->discount, 2, ",", " ");
        else
            return number_format($this->discount, 0, ",", " ");
    }

    public function getCartTotalAttribute(): float
    {
        if (empty($this->pivot)) return 0;
        return $this->pivot->quantity * $this->price;
    }

    public function getHumanCartTotalAttribute(): string
    {
        if ($this->cart_total - intval($this->cart_total) > 0)
            return number_format($this->cart_total, 2, ",", " ");
        else
            return number_format($this->cart_total, 0, ",", " ");
    }

    public function getCartOldTotalAttribute(): float
    {
        if (empty($this->pivot)) return 0;
        if (empty($this->old_price)) return 0;
        return $this->pivot->quantity * $this->old_price;
    }

    public function getHumanCartOldTotalAttribute(): string
    {
        if ($this->cart_old_total - intval($this->cart_old_total) > 0)
            return number_format($this->cart_old_total, 2, ",", " ");
        else
            return number_format($this->cart_old_total, 0, ",", " ");
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
