<?php

namespace GIS\ProductVariation;

use Illuminate\Support\ServiceProvider;

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

    }

    protected function expandConfiguration(): void
    {

    }

    protected function addLivewireComponents(): void
    {

    }
}
