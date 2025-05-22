<?php

namespace GIS\ProductVariation;

use GIS\ProductVariation\Helpers\OrderActionsManager;
use GIS\ProductVariation\Interfaces\ProductVariationInterface;
use GIS\ProductVariation\Livewire\Web\Catalog\ChooseVariationWire;
use GIS\ProductVariation\Livewire\Web\Catalog\OrderSingleVariationWire;
use GIS\ProductVariation\Models\Order;
use GIS\ProductVariation\Models\OrderItem;
use GIS\ProductVariation\Models\OrderState;
use GIS\ProductVariation\Models\ProductVariation;
use GIS\ProductVariation\Observers\OrderItemObserver;
use GIS\ProductVariation\Observers\OrderObserver;
use GIS\ProductVariation\Observers\OrderStateObserver;
use GIS\ProductVariation\Observers\ProductVariationObserver;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use GIS\ProductVariation\Livewire\Admin\ProductVariations\ListWire as AdminVariationListWire;
use GIS\ProductVariation\Livewire\Admin\OrderStates\ListWire as AdminOrderStateListWire;

class ProductVariationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . "/database/migrations");
        $this->loadRoutesFrom(__DIR__ . "/routes/admin.php");
        $this->mergeConfigFrom(__DIR__ . "/config/product-variation.php", "product-variation");
        $this->initFacades();
        $this->bindInterfaces();
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . "/resources/views", "pv");
        $this->addLivewireComponents();
        $this->expandConfiguration();
        $this->observeModels();
        $this->listenEvents();
    }

    protected function initFacades(): void
    {
        $this->app->singleton("order-actions", function () {
            $orderActionsManagerClass = config("product-variation.customOrderActionsManager") ?? OrderActionsManager::class;
            return new $orderActionsManagerClass();
        });
    }

    protected function bindInterfaces(): void
    {
        $variationClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
        $this->app->bind(ProductVariationInterface::class, $variationClass);
    }

    protected function listenEvents(): void
    {

    }

    protected function observeModels(): void
    {
        $variationModelClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
        $variationObserverClass = config("product-variation.customVariationModelObserver") ?? ProductVariationObserver::class;
        $variationModelClass::observe($variationObserverClass);

        $stateModelClass = config("product-variation.customOrderStateModel") ?? OrderState::class;
        $stateObserverClass = config("product-variation.customOrderStateModelObserver") ?? OrderStateObserver::class;
        $stateModelClass::observe($stateObserverClass);

        $orderModelClass = config("product-variation.customOrderModel") ?? Order::class;
        $orderObserverClass = config("product-variation.customOrderModelObserver") ?? OrderObserver::class;
        $orderModelClass::observe($orderObserverClass);

        $itemModelClass = config("product-variation.customOrderItemModel") ?? OrderItem::class;
        $itemObserverClass = config("product-variation.customOrderItemModelObserver") ?? OrderItemObserver::class;
        $itemModelClass::observe($itemObserverClass);
    }

    protected function expandConfiguration(): void
    {
        $pv = app()->config["product-variation"];

        $um = app()->config["user-management"];
        $permissions = $um["permissions"];
        $permissions[] = [
            "title" => $pv["variationPolicyTitle"],
            "key" => $pv["variationPolicyKey"],
            "policy" => $pv["variationPolicy"]
        ];
        $permissions[] = [
            "title" => $pv["statePolicyTitle"],
            "key" => $pv["statePolicyKey"],
            "policy" => $pv["statePolicy"]
        ];
        $permissions[] = [
            "title" => $pv["orderPolicyTitle"],
            "key" => $pv["orderPolicyKey"],
            "policy" => $pv["orderPolicy"]
        ];
        app()->config["user-management.permissions"] = $permissions;
    }

    protected function addLivewireComponents(): void
    {
        $component = config("product-variation.customAdminVariationListComponent");
        Livewire::component(
            "pv-admin-variation-list",
            $component ?? AdminVariationListWire::class
        );

        $component = config("product-variation.customAdminOrderStateListComponent");
        Livewire::component(
            "pv-admin-order-states-list",
            $component ?? AdminOrderStateListWire::class
        );

        $component = config("product-variation.customWebChooseVariationComponent");
        Livewire::component(
            "pv-choose-variation",
            $component ?? ChooseVariationWire::class
        );

        $component = config("product-variation.customWebOrderSingleVariationComponent");
        Livewire::component(
            "pv-order-single-variation",
            $component ?? OrderSingleVariationWire::class
        );
    }
}
