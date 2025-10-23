@php($key = "product-variation-choose-{$product->id}-" . now()->timestamp)
<livewire:pv-teaser-choose-variation :$product wire:key="{{ $key }}" />
