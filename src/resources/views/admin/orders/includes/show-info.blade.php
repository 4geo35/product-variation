<div class="flex flex-col gap-indent-half">
    <div class="row">
        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
            <h3 class="font-semibold">Дата оформления</h3>
        </div>
        <div class="col w-full xs:w-3/5">{{ $order->created_human }}</div>
    </div>

    <div class="row">
        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
            <h3 class="font-semibold">Пользователь</h3>
        </div>
        <div class="col w-full xs:w-3/5">
            @if($order->user)
                <a href="{{ route("admin.users") }}?email={{ $order->user->email }}"
                   target="_blank"
                   class="text-primary hover:text-primary-hover">
                    {{ $order->user->name }}
                </a>
            @else
                -
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
            <h3 class="font-semibold">IP</h3>
        </div>
        <div class="col w-full xs:w-3/5">{{ $order->ip }}</div>
    </div>

    <div class="row">
        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
            <h3 class="font-semibold">Сумма</h3>
        </div>
        <div class="col w-full xs:w-3/5">{{ $order->human_total }} руб.</div>
    </div>
</div>
