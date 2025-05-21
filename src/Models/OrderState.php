<?php

namespace GIS\ProductVariation\Models;

use GIS\ProductVariation\Interfaces\OrderStateInterface;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderState extends Model implements OrderStateInterface
{
    use ShouldSlug;

    protected $fillable = [
        "title",
        "key",
        "slug",
    ];

    // TODO: add orders

    public function fixKey($updating = false): void
    {
        if ($updating && ($this->original["key"] == $this->key)) return;

        $key = empty($this->key) ? $this->title : $this->key;
        $key = Str::slug($key);
        $buf = $key;
        $i = 1;
        $id = $updating ? $this->id : 0;
        $stateModelClass = config("product-variation.customOrderStateModel") ?? self::class;
        while (
            $stateModelClass::query()
                ->select("id")
                ->where("key", $buf)
                ->where("id", "!=", $id)
                ->count()
        ) { $buf = $key . "-" . $i++; }
        $this->key = $buf;
    }
}
