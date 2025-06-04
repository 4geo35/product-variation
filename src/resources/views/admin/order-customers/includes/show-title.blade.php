<div class="flex justify-between items-center overflow-x-auto beautify-scrollbar">
    <h2 class="font-medium text-2xl text-nowrap mr-indent-half">Данные покупателя</h2>
    <div class="flex justify-end">
        <button type="button" class="btn btn-dark btn-sm px-btn-x-ico"
                @cannot("update", $order) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="showEdit">
            <x-tt::ico.edit />
        </button>
    </div>
</div>
