<?php

namespace GIS\ProductVariation\Facades;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\ProductVariation\Helpers\ProductVariationActionsManager;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getPricesForCategory(CategoryInterface $category, bool $includeSubs)
 * @method static void forgetPricesForCategory(CategoryInterface $category)
 * @method static Builder getPriceQuery(array $range, bool $needBetween = true)
 *
 * @see ProductVariationActionsManager
 */
class ProductVariationActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "product-variation-actions";
    }
}
