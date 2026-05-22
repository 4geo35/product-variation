<?php

namespace GIS\ProductVariation\Events;

use GIS\ProductVariation\Interfaces\ProductVariationInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VariationPriceChangedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public ProductVariationInterface $variation,
    ) {}
}
