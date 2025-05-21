<?php

namespace GIS\ProductVariation\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

interface OrderInterface
{
    public function state(): BelongsTo;
    public function user(): BelongsTo;
    public function customer(): HasOne;
    public function items(): HasMany;
}
