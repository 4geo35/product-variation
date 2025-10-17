<button type="button" class="btn btn-primary {{ !$variationId ? 'hidden' : '' }} mt-indent-half"
        wire:click="showModal" wire:loading.attr="disabled">
    Купить
</button>
