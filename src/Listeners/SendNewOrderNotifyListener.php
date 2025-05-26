<?php

namespace GIS\ProductVariation\Listeners;

use GIS\ProductVariation\Events\CreateNewOrderEvent;
use GIS\ProductVariation\Notifications\NewOrderClientNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewOrderNotifyListener implements ShouldQueue
{
    public function __construct() {}

    public function handle(CreateNewOrderEvent $event): void
    {
        $order = $event->order;

        $clientEmails = config("product-variation.clientNotifyEmails");
        if (! empty($clientEmails) && config("product-variation.enableClientNotify")) {
            $order->notify(new NewOrderClientNotification());
        }
    }
}
