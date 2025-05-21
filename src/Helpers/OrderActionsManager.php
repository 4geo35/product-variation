<?php

namespace GIS\ProductVariation\Helpers;

use GIS\ProductVariation\Interfaces\OrderStateInterface;
use GIS\ProductVariation\Models\Order;
use GIS\ProductVariation\Models\OrderState;

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

    protected function generateRandomPin($letter, $length): string
    {
        if ($letter) {
            $characters = config("product-variation.availableLetters");
            return $characters[mt_rand(0, (count($characters) - 1))] . "-" . $this->generateRandomDigits($length);
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
