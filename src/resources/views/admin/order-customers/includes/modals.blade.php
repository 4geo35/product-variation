<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">Редактировать покупателя</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="update" class="space-y-indent-half" id="customerDataForm">
            <div>
                <label for="customerName" class="inline-block mb-2">
                    Имя <span class="text-danger">*</span>
                </label>
                <input type="text" id="customerName"
                       class="form-control {{ $errors->has("name") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="name">
                <x-tt::form.error name="name"/>
            </div>

            <div>
                <label for="customerEmail" class="inline-block mb-2">
                    E-mail
                </label>
                <input type="text" id="customerEmail"
                       class="form-control {{ $errors->has("email") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="email">
                <x-tt::form.error name="email"/>
            </div>

            <div>
                <label for="customerPhone" class="inline-block mb-2">
                    Телефон
                </label>
                <input type="text" id="customerPhone"
                       class="form-control {{ $errors->has("phone") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="phone">
                <x-tt::form.error name="phone"/>
            </div>

            <div>
                <label for="customerDescription" class="inline-block mb-2">
                    Комментарий
                </label>
                <textarea id="customerDescription" class="form-control !min-h-20" wire:model="comment"></textarea>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="customerDataForm" class="btn btn-primary" wire:loading.attr="disabled">
                    Обновить
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
