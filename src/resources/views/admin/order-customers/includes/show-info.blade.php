<div class="flex flex-col gap-indent-half">
    <div class="row">
        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
            <h3 class="font-semibold">Имя</h3>
        </div>
        <div class="col w-full xs:w-3/5">{{ $customer->name }}</div>
    </div>

    <div class="row">
        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
            <h3 class="font-semibold">Email</h3>
        </div>
        <div class="col w-full xs:w-3/5">{{ $customer->email }}</div>
    </div>

    <div class="row">
        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
            <h3 class="font-semibold">Телефон</h3>
        </div>
        <div class="col w-full xs:w-3/5">{{ $customer->phone }}</div>
    </div>

    <div class="row">
        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
            <h3 class="font-semibold">Комментарий</h3>
        </div>
        <div class="col w-full xs:w-3/5">{{ $customer->comment }}</div>
    </div>
</div>
