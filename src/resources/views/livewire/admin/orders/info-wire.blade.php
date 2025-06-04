<div class="card h-full">
    <div class="card-header">
        <div class="flex justify-between items-center overflow-x-auto beautify-scrollbar">
            <h2 class="font-medium text-2xl text-nowrap mr-indent-half">Данные заказа</h2>

            <div>
                @if ($displayState)
                    <div class="flex items-center justify-start space-x-1">
                        <select class="form-select form-select-sm" aria-label="Статус" wire:model.live="stateId">
                            @foreach($orderStates as $state)
                                <option value="{{ $state->id }}">{{ $state->title }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-sm px-btn-x-ico btn-outline-secondary cursor-pointer" wire:click="closeState">
                            <x-tt::ico.cross />
                        </button>
                        <button type="button" class="btn btn-sm px-btn-x-ico btn-outline-success cursor-pointer" wire:click="saveState">ОК</button>
                    </div>
                @else
                    <button type="button" class="text-primary hover:text-primary-hover cursor-pointer" wire:click="editStatus({{ $order->id }})">
                        {{ $order->state->title }}
                    </button>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        @include("pv::admin.orders.includes.show-info")
    </div>
</div>
