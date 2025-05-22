<div class="flex justify-between">
    <div class="flex flex-col space-y-indent-half md:flex-row md:space-x-indent-half md:space-y-0">
        <input type="text" aria-label="Заголовок" placeholder="Заголовок" class="form-control" wire:model.live="searchTitle">
        <button type="button" class="btn btn-outline-primary" wire:click="clearSearch">
            Очистить
        </button>
    </div>

    <div>
        <button type="button" class="btn btn-primary px-btn-x-ico lg:px-btn-x ml-indent-half" wire:click="showCreate">
            <x-tt::ico.circle-plus />
            <span class="hidden lg:inline-block pl-btn-ico-text">Добавить</span>
        </button>
    </div>
</div>
