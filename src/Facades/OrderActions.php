<?php

namespace GIS\ProductVariation\Facades;

use GIS\ProductVariation\Helpers\OrderActionsManager;
use GIS\ProductVariation\Interfaces\OrderStateInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static OrderStateInterface getNewState()
 * @method static string generateUniqueNumber($letter = true, $length =8)
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
