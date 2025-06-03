<?php

namespace GIS\ProductVariation\Models;

use GIS\ProductVariation\Interfaces\OrderCustomerInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderCustomer extends Model implements OrderCustomerInterface
{
    protected $fillable = [
        "name",
        "email",
        "phone",
        "comment",
    ];

    public function order(): BelongsTo
    {
        $orderModelClass = config("product-variation.customOrderModel") ?? Order::class;
        return $this->belongsTo($orderModelClass, "order_id");
    }
}
