<?php

namespace GIS\ProductVariation\Livewire\Web\Catalog;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\ProductVariation\Traits\InitFirstVariation;
use Illuminate\View\View;
use Livewire\Component;

class ProductTeaserChooseVariationWire extends Component
{
    use InitFirstVariation;

    public function mount(): void
    {
        $this->setFirstVariation();
    }

    public function updatedVariationId($value): void
    {
        $this->variation = $this->variations->find($value);
        $this->changeVariationEvent();
    }

    public function render(): View
    {
        debugbar()->info($this->variation);
        return view("pv::livewire.web.catalog.product-teaser-choose-variation-wire");
    }

    protected function changeVariationEvent(): void
    {
        $this->dispatch("switch-variation", $this->variationId, $this->product->id);
    }
}
