<?php

return [
    // Admin
    "customVariationModel" => null,
    "customVariationModelObserver" => null,

    // Components
    "customAdminVariationListComponent" => null,

    "customWebChooseVariationComponent" => null,

    // Policy
    "variationPolicyTitle" => "Управление вариациями",
    "variationPolicy" => \GIS\ProductVariation\Policies\ProductVariationPolicy::class,
    "variationPolicyKey" => "product_variations",
];
