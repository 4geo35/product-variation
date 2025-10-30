<?php

namespace GIS\ProductVariation\Models;

use GIS\ProductVariation\Interfaces\MeasurementUnitInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeasurementUnit extends Model implements MeasurementUnitInterface
{
    protected $fillable = [
        "title",
    ];

    public function variations(): HasMany
    {
        $variationModelClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
        return $this->hasMany($variationModelClass, "unit_id");
    }
}
