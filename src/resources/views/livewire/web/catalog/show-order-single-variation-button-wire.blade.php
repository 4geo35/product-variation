<div class="{{ !$variationId ? 'hidden' : '' }} flex flex-col lg:flex-row items-start lg:items-center">
    <button type="button" class="btn btn-primary mt-indent-half lg:mr-indent-half shrink-0"
            wire:click="showModal" wire:loading.attr="disabled">
        Купить
    </button>
    @if ($variation && $variation->minimal_order)
        <div class="mt-indent-half text-body/60 text-sm">
            Минимальный заказ: <span class="text-nowrap font-semibold">{{ $variation->minimal_order }} {{ $variation->unit_text }}</span>
        </div>
    @endif
</div>
