<?php

return [
    "defaultMeasurement" => "шт.",

    // Order settings
    "orderNumberHasLetter" => true,
    "orderDigitsLength" => 8,
    "availableLetters" => "ABCDEFGHIJKLMNOPQRSTUVWXYZ",

    // Filter
    "priceFilterKey" => "product-price",
    "priceSortReplaceNull" => 1000000000,

    // Sort
    "sortOptions" => [
        "price.desc" => (object) [
            "title" => "Сначала дорогие",
            "by" => "price",
            "direction" => "desc",
            "ico" => "cp::web.catalog.sort.publish-down",
        ],
        "price.asc" => (object) [
            "title" => "Сначала дешевые",
            "by" => "price",
            "direction" => "asc",
            "ico" => "cp::web.catalog.sort.publish-up",
        ]
    ],

    // Notifications
    "clientNotifyEmails" => env("CLIENT_ORDER_NOTIFICATION_EMAILS"),
    "enableClientNotify" => true,

    // Listeners
    "customNewOrderListener" => null,

    // Admin
    "customVariationModel" => null,
    "customVariationModelObserver" => null,

    "customUnitModel" => null,
    "customUnitModelObserver" => null,

    "customOrderStateModel" => null,
    "customOrderStateModelObserver" => null,

    "customOrderModel" => null,
    "customOrderModelObserver" => null,

    "customOrderItemModel" => null,
    "customOrderItemModelObserver" => null,

    "customOrderCustomerModel" => null,
    "customOrderCustomerModelObserver" => null,

    "customAdminOrderController" => null,
    "customAdminOrderStateController" => null,
    "customAdminUnitController" => null,

    // Facades
    "customProductVariationActionsManager" => null,
    "customOrderActionsManager" => null,

    // Components
    "customAdminVariationListComponent" => null,
    "customAdminOrderStateIndexComponent" => null,
    "customAdminOrderIndexComponent" => null,
    "customAdminManageCustomerComponent" => null,
    "customAdminManageItemsComponent" => null,
    "customAdminOrderInfoComponent" => null,
    "customAminUnitIndexComponent" => null,

    "customWebChooseVariationComponent" => null,
    "customWebOrderSingleVariationComponent" => null,
    "customWebTeaserChooseVariationComponent" => null,
    "customWebShowOrderSingleVariationButtonComponent" => null,

    // Policy
    "variationPolicyTitle" => "Управление вариациями",
    "variationPolicy" => \GIS\ProductVariation\Policies\ProductVariationPolicy::class,
    "variationPolicyKey" => "product_variations",

    "statePolicy" => \GIS\ProductVariation\Policies\OrderStatePolicy::class,
    "statePolicyTitle" => "Управление статусами заказа",
    "statePolicyKey" => "order_states",

    "orderPolicy" => \GIS\ProductVariation\Policies\OrderPolicy::class,
    "orderPolicyKey" => "orders",
    "orderPolicyTitle" => "Управление заказами",

    "unitPolicy" => \GIS\ProductVariation\Policies\MeasurementUnitPolicy::class,
    "unitPolicyKey" => "measurement_units",
    "unitPolicyTitle" => "Управление единицами измерения",
];
