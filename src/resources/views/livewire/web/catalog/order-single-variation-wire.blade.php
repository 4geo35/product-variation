<x-tt::modal.dialog wire:model="displayData">
    <x-slot name="title">
        <div>
            <span>Заказать товар </span>
            @if ($variation && $variation->product)
                <span class="font-semibold">{{ $variation->product->title }}</span>
            @endif
        </div>
    </x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="store" class="space-y-indent-half" id="orderSingleForm">
            <x-tt::notifications.success prefix="single-order-" />

            <div class="m-0 h-0 w-0 overflow-hidden">
                <input type="text" class="form-control" wire:model="hidden">
                <x-tt::form.error name="hidden"/>
            </div>

            <div>
                <label for="singleName" class="inline-block mb-2">
                    Ваше имя<span class="text-danger">*</span>
                </label>
                <input type="text" id="singleName"
                       class="form-control {{ $errors->has("name") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="name">
                <x-tt::form.error name="name"/>
            </div>

            <div>
                <label for="singleEmail" class="inline-block mb-2">
                    E-mail
                </label>
                <input type="email" id="singleEmail"
                       class="form-control {{ $errors->has("email") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="email">
                <x-tt::form.error name="email"/>
            </div>

            <div>
                <label for="singlePhone" class="inline-block mb-2">
                    Номер телефона
                </label>
                <input type="text" id="singlePhone"
                       class="form-control {{ $errors->has("phone") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="phone">
                <x-tt::form.error name="phone"/>
            </div>

            <div>
                <label for="singleDescription" class="inline-block mb-2">
                    Комментарий
                </label>
                <textarea id="singleDescription" class="form-control !min-h-20" wire:model="comment"></textarea>
            </div>

            <div>
                <div class="form-check">
                    <input type="checkbox" wire:model="policy" id="singlePolicy" required
                           class="form-check-input {{ $errors->has('policy') ? 'border-danger' : '' }}"/>
                    <label for="singlePolicy" class="form-check-label">
                        @include("tt::policy.check-text")
                    </label>
                </div>
                <x-tt::form.error name="policy"/>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeOrder">
                    Отмена
                </button>
                <button type="submit" form="orderSingleForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    Заказать
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.dialog>
