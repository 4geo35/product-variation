<?php

use GIS\ProductVariation\Http\Controllers\Admin\UnitController;
use Illuminate\Support\Facades\Route;
use GIS\ProductVariation\Http\Controllers\Admin\OrderController;
use GIS\ProductVariation\Http\Controllers\Admin\OrderStateController;

Route::middleware(["web", "auth", "app-management"])
    ->prefix("admin")
    ->as("admin.")
    ->group(function () {
        Route::prefix("orders")
            ->as("orders.")
            ->group(function () {
                $orderControllerClass = config("product-variation.customAdminOrderController") ?? OrderController::class;
                Route::get("/", [$orderControllerClass, "index"])->name("index");
                Route::get("/{order}", [$orderControllerClass, "show"])->name("show");
            });

        Route::prefix("order-states")
            ->as("order-states.")
            ->group(function () {
                $orderStateControllerClass = config("product-variation.customAdminOrderStateController") ?? OrderStateController::class;
                Route::get("/", [$orderStateControllerClass, "index"])->name("index");
            });

        Route::prefix("measurement-units")
            ->as("measurement-units.")
            ->group(function () {
                $unitControllerClass = config("product-variation.customAdminUnitController") ?? UnitController::class;
                Route::get("/", [$unitControllerClass, "index"])->name("index");
            });
    });
