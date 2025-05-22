<?php

namespace GIS\ProductVariation\Helpers;

use GIS\ProductVariation\Interfaces\OrderInterface;
use GIS\ProductVariation\Interfaces\OrderItemInterface;
use GIS\ProductVariation\Interfaces\OrderStateInterface;
use GIS\ProductVariation\Interfaces\ProductVariationInterface;
use GIS\ProductVariation\Models\Order;
use GIS\ProductVariation\Models\OrderItem;
use GIS\ProductVariation\Models\OrderState;
use GIS\ProductVariation\Models\ProductVariation;

class OrderActionsManager
{
    public function getNewState(): OrderStateInterface
    {
        $orderStateModel = config("product-variation.customOrderStateModel") ?? OrderState::class;
        return $orderStateModel::query()
            ->where("key", "new")
            ->firstOrCreate([
                "title" => "Новый",
                "slug" => "new",
                "key" => "new",
            ]);
    }

    public function generateUniqueNumber($letter = true, $length = 8): string
    {
        $pin = $this->generateRandomPin($letter, $length);
        $orderModelClass = config("product-variation.customOrderModel") ?? Order::class;
        while (
            $orderModelClass::query()->select("id")->where("number", $pin)->count("id")
        ) {
            $pin = $this->generateRandomPin($letter, $length);
        }
        return $pin;
    }

    public function recalculateOrderTotal(OrderInterface $order): void
    {
        $total = 0;
        $items = $order->items()->select("price", "quantity")->get();
        foreach ($items as $item) {
            $total += $item->total;
        }
        $order->total = $total;
        $order->save();
    }

    public function addVariationsToOrder(OrderInterface $order, array $variationsInfo): void
    {
        $ids = array_keys($variationsInfo);
        $orderItemModelClass = config("product-variation.customOrderItemModel") ?? OrderItem::class;
        $orderItems = $orderItemModelClass::query()
            ->where("order_id", $order->id)
            ->whereIn("variation_id", $ids)
            ->get();
        // Изменить существующие
        foreach ($orderItems as $orderItem) {
            /**
             * @var OrderItemInterface $orderItem
             */
            $id = $orderItem->variation_id;
            $quantity = $variationsInfo[$id]->quantity;
            $this->changeOrderItemQuantity($orderItem, $quantity);
            if ($orderItem->price !== $variationsInfo[$id]->price) {
                $orderItem->price = $variationsInfo[$id]->price;
                $orderItem->save();
            }
            unset($variationsInfo[$id]);
        }
        // Добавить новые
        foreach ($variationsInfo as $id => $info) {
            $this->addItemToOrder($order, $id, $info);
        }
        $this->recalculateOrderTotal($order);
    }

    public function changeOrderItemQuantity(OrderItemInterface $item, int $quantity = 1, bool $increase = true): void
    {
        if ($increase) $item->quantity += $quantity;
        else $item->quantity = $quantity;
        $item->save();
    }

    public function addItemToOrder(OrderInterface $order, int $variationId, object $info): ?OrderItemInterface
    {
        try {
            $variationModelClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
            $variation = $variationModelClass::query()
                ->where("id", $variationId)
                ->firstOrFail();
        } catch (\Exception $e) {
            return null;
        }
        /**
         * @var ProductVariationInterface $variation
         */
        $quantity = $info->quantity;
        $productId = $variation->product_id;
        try {
            if (empty($info->price)) $price = $variation->price;
            else $price = $info->price;

            $orderItem = $order->items()->create([
                "sku" => $variation->sku,
                "price" => $price,
                "quantity" => $quantity,
                "product_id" => $productId,
                "variation_id" => $variationId,
            ]);
            /**
             * @var OrderItemInterface $orderItem
             */
        } catch (\Exception $exception) {
            return null;
        }
        return $orderItem;
    }

    protected function generateRandomPin($letter, $length): string
    {
        if ($letter) {
            $characters = config("product-variation.availableLetters");
            return $characters[mt_rand(0, (strlen($characters) - 1))] . "-" . $this->generateRandomDigits($length);
        } else {
            return $this->generateRandomDigits($length);
        }
    }

    protected function generateRandomDigits($count): string
    {
        $number = "";
        for ($i = 0; $i < $count; $i++) {
            $number .= mt_rand(0, 9);
        }
        return $number;
    }
}
