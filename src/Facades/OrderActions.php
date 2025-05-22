<?php

namespace GIS\ProductVariation\Facades;

use GIS\ProductVariation\Helpers\OrderActionsManager;
use GIS\ProductVariation\Interfaces\OrderInterface;
use GIS\ProductVariation\Interfaces\OrderItemInterface;
use GIS\ProductVariation\Interfaces\OrderStateInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static OrderStateInterface getNewState()
 * @method static string generateUniqueNumber($letter = true, $length =8)
 * @method static void recalculateOrderTotal(OrderInterface $order)
 * @method static void addVariationsToOrder(OrderInterface $order, array $variationsInfo)
 * @method static void changeOrderItemQuantity(OrderItemInterface $item, int $quantity = 1, bool $increase = true)
 * @method static OrderItemInterface addItemToOrder(OrderInterface $order, $variationId, object $info)
 *
 * @see OrderActionsManager
 */
class OrderActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "order-actions";
    }
}
