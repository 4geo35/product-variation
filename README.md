### Установка

Добавить в `tailwind.admin.config.js`, созданный в пакете `tailwindcss-theme`.

    "./vendor/4geo35/product-variation/src/resources/views/components/**/*.blade.php",
    "./vendor/4geo35/product-variation/src/resources/views/admin/**/*.blade.php",
    "./vendor/4geo35/product-variation/src/resources/views/livewire/admin/**/*.blade.php",

Добавить в `tailwind.config.js`, созданный в пакете `tailwindcss-theme`.

    "./vendor/4geo35/product-variation/src/resources/views/components/**/*.blade.php",
    "./vendor/4geo35/product-variation/src/resources/views/web/**/*.blade.php",
    "./vendor/4geo35/product-variation/src/resources/views/livewire/web/**/*.blade.php",

Создать таблицу измерений:

    php artisan migrate

#### Views

Сокращение для представлений: `pv`  
Меню для панели администрирования: `<x-pv::menu-item/>` 

#### Livewire Components

- `pv-choose-variation`
- `pv-order-single-variation`
- `pv-teaser-choose-variation`
- `pv-show-order-single-variation-button`

#### Config

Название файла: `product-variation`
