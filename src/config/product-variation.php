<?php

return [
    // Admin
    "customVariationModel" => null,
    "customVariationModelObserver" => null,

    "customOrderStateModel" => null,
    "customOrderStateModelObserver" => null,

    // Components
    "customAdminVariationListComponent" => null,

    "customWebChooseVariationComponent" => null,

    // Policy
    "variationPolicyTitle" => "Управление вариациями",
    "variationPolicy" => \GIS\ProductVariation\Policies\ProductVariationPolicy::class,
    "variationPolicyKey" => "product_variations",

    "statePolicy" => \GIS\ProductVariation\Policies\OrderStatePolicy::class,
    "statePolicyTitle" => "Управление статусами заказа",
    "statePolicyKey" => "order_states",
];
