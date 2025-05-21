<?php

namespace GIS\ProductVariation\Models;

use App\Models\User;
use GIS\ProductVariation\Interfaces\OrderInterface;
use GIS\TraitsHelpers\Traits\ShouldHumanDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class Order extends Model implements OrderInterface
{
    use ShouldHumanDate, Notifiable;

    protected $fillable = [
        "total",
    ];

    public function getRouteKeyName(): string
    {
        return "number";
    }

    public function routeNotificationForMail(Notification $notification): array
    {
        return config("product-variation.clientNotifyEmails");
    }

    public function state(): BelongsTo
    {
        $stateModelClass = config("product-variation.customOrderStateModel") ?? OrderState::class;
        return $this->belongsTo($stateModelClass, "state_id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function customer(): HasOne
    {
        $customerModelClass = config("product-variation.customOrderCustomerModel") ?? OrderCustomer::class;
        return $this->hasOne($customerModelClass, "order_id");
    }

    public function items(): HasMany
    {
        $itemModelClass = config("product-variation.customOrderItemModel") ?? OrderItem::class;
        return $this->hasMany($itemModelClass, "order_id");
    }

    public function getHumanTotalAttribute(): string
    {
        if ($this->total - intval($this->total) > 0)
            return number_format($this->total, 2, ",", " ");
        else
            return number_format($this->total, 0, ",", " ");
    }
}
