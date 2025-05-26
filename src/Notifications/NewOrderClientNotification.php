<?php

namespace GIS\ProductVariation\Notifications;

use GIS\ProductVariation\Interfaces\OrderInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderClientNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct() {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(OrderInterface $order): MailMessage
    {
        return (new MailMessage)
            ->subject('Новый заказ')
            ->markdown("pv::mail.order.new-order-client", [
                "order" => $order,
                "items" => $order->items()->get(),
                "url" => route("admin.orders.index") . "?number={$order->number}"
            ]);
    }
}
