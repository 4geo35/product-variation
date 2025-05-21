<?php

namespace GIS\ProductVariation\Events;

use GIS\ProductVariation\Interfaces\OrderInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateNewOrderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public OrderInterface $order
    ) {}
}
