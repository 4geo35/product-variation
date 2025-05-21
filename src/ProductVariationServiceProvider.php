<?php

namespace GIS\ProductVariation;

use GIS\ProductVariation\Livewire\Web\Catalog\ChooseVariationWire;
use GIS\ProductVariation\Models\OrderState;
use GIS\ProductVariation\Models\ProductVariation;
use GIS\ProductVariation\Observers\OrderStateObserver;
use GIS\ProductVariation\Observers\ProductVariationObserver;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use GIS\ProductVariation\Livewire\Admin\ProductVariations\ListWire as AdminVariationListWire;
use NunoMaduro\Collision\Adapters\Phpunit\State;

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

    }

    protected function bindInterfaces(): void
    {

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
        app()->config["user-management.permissions"] = $permissions;
    }

    protected function addLivewireComponents(): void
    {
        $component = config("product.variation.customAdminVariationListComponent");
        Livewire::component(
            "pv-admin-variation-list",
            $component ?? AdminVariationListWire::class
        );

        $component = config("product.variation.customWebChooseVariationComponent");
        Livewire::component(
            "pv-choose-variation",
            $component ?? ChooseVariationWire::class
        );
    }
}
