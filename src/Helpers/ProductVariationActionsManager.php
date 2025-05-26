<?php

namespace GIS\ProductVariation\Helpers;

use GIS\CategoryProduct\Facades\CategoryActions;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\ProductVariation\Models\ProductVariation;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductVariationActionsManager
{
    public function getPricesForCategory(CategoryInterface $category, bool $includeSubs): array
    {
        $key = "product-filter-getPricesForCategory:{$category->id}";
        $key .= $includeSubs ? "-true" : "-false";
        $pIds = CategoryActions::getProductIds($category, $includeSubs);
        return Cache::rememberForever($key, function () use ($pIds) {
            $variationModelClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
            $variations = $variationModelClass::query()
                ->select("id", "price", "old_price", "sale")
                ->whereIn("product_id", $pIds)
                ->whereNotNull("published_at")
                ->get();
            $prices = [];
            foreach ($variations as $variation) {
                $price = $variation->price;
                if ($price >= 0 && ! in_array($price, $prices)) {
                    $prices[] = $price;
                }
            }
            return $prices;
        });
    }

    public function forgetPricesForCategory(CategoryInterface $category): void
    {
        $key = "product-filter-getPricesForCategory:{$category->id}";
        Cache::forget("$key-true");
        Cache::forget("$key-false");
        if ($category->parent_id) $this->forgetPricesForCategory($category->parent);
    }

    public function getPriceQuery(array $range, bool $needBetween = true): Builder
    {
        $query = DB::table("product_variations")
            ->select("product_id", DB::raw("min(price) as minimal"))
            ->whereNotNull("published_at");
        if ($needBetween && ! empty($range["from"]) && ! empty($range["to"])) {
            $from = $range["from"];
            $to = $range["to"];
            $query->whereBetween("price", [$from, $to + 1]);
        }
        return $query->groupBy("product_id");
    }
}
