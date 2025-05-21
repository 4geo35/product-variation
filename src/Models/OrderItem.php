<?php

namespace GIS\ProductVariation\Models;

use GIS\CategoryProduct\Models\Product;
use GIS\ProductVariation\Interfaces\OrderItemInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model implements OrderItemInterface
{
    protected $fillable = [
        "product_id",
        "variation_id",

        "sku",
        "price",
        "quantity",
        "variation_title",
        "title",
    ];

    public function order(): BelongsTo
    {
        $orderModelClass = config("product-variation.customOrderModel") ?? Order::class;
        return $this->belongsTo($orderModelClass, "order_id");
    }

    public function product(): BelongsTo
    {
        $productModelClass = config("category-product.customProductModel") ?? Product::class;
        return $this->belongsTo($productModelClass, "product_id");
    }

    public function variation(): BelongsTo
    {
        $variationModelClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
        return $this->belongsTo($variationModelClass, "variation_id");
    }

    public function getHumanPriceAttribute(): string
    {
        if ($this->price - intval($this->price) > 0)
            return number_format($this->price, 2, ",", " ");
        else
            return number_format($this->price, 0, ",", " ");
    }

    public function getTotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    public function getHumanTotalAttribute(): string
    {
        if ($this->total - intval($this->total) > 0)
            return number_format($this->total, 2, ",", " ");
        else
            return number_format($this->total, 0, ",", " ");
    }
}
