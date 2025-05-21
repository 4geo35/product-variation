<?php

namespace GIS\ProductVariation\Livewire\Web\Catalog;

use GIS\ProductVariation\Traits\InitFirstVariation;
use Illuminate\View\View;
use Livewire\Component;

class ChooseVariationWire extends Component
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
        return view("pv::livewire.web.catalog.choose-variation-wire");
    }

    protected function changeVariationEvent(): void
    {
        $this->dispatch("switch-variation", $this->variationId);
    }
}
