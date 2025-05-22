<div class="flex justify-between">
    <div class="flex flex-col space-y-indent-half md:flex-row md:space-x-indent-half md:space-y-0">
        <input type="text" aria-label="Номер" placeholder="Номер" class="form-control" wire:model.live="searchNumber">
        <input type="text" aria-label="Email" placeholder="Email" class="form-control" wire:model.live="searchEmail">
        <input type="text" aria-label="Телефон" placeholder="Телефон" class="form-control" wire:model.live="searchPhone">
        <button type="button" class="btn btn-outline-primary" wire:click="clearSearch">
            Очистить
        </button>
    </div>
</div>
