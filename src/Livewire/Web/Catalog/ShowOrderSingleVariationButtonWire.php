<?php

namespace GIS\ProductVariation\Livewire\Web\Catalog;

use GIS\ProductVariation\Traits\InitFirstVariation;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowOrderSingleVariationButtonWire extends Component
{
    use InitFirstVariation;

    public function mount(): void
    {
        $this->setFirstVariation();
    }

    public function render(): View
    {
        return view('pv::livewire.web.catalog.show-order-single-variation-button-wire');
    }

    #[On("switch-variation")]
    public function setVariation(int $variationId, int $productId): void
    {
        if ($this->product->id !== $productId) { return; }
        $this->variation = $this->variations->find($variationId);
        if (!$this->variation) { return; }
        $this->variationId = $variationId;
    }

    public function showModal(): void
    {
        debugbar()->info($this->variation);
    }
}
