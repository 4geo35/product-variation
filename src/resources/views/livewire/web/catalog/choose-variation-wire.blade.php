<div>
    @if ($variation)
        <div class="flex flex-wrap items-center space-x-indent mb-indent">
            <div class="text-4xl sm:text-5xl font-bold text-nowrap mb-2">
                {{ $variation->human_price }} р. <span class="text-body/60 text-xl sm:text-2xl">/ {{ $variation->unit_text }}</span>
            </div>
            @if ($variation->sale)
                <div class="text-2xl sm:text-3xl font-medium text-body/60 line-through text-nowrap mb-2">{{ $variation->human_old_price }} р.</div>
            @endif
        </div>
    @endif
    @if ($variations->count() > 1)
        <div class="space-y-indent-half">
            @foreach($variations as $item)
                <div class="form-check items-start">
                    <input class="form-check-input mt-1" id="productVariation-{{ $item->sku }}"
                           type="radio" name="productVariation" value="{{ $item->id }}" wire:model.live="variationId">
                    <label class="ml-indent-half flex flex-col items-start justify-start" for="productVariation-{{ $item->sku }}">
                        <span>{{ $item->title }}</span>
                        <span class="flex items-center justify-start space-x-indent-half">
                            <span class="text-lg font-medium">
                                {{ $item->human_price }} р. <span class="text-body/60 text-sm">/ {{ $variation->unit_text }}</span>
                            </span>
                            @if ($item->sale)
                                <span class="text-sm font-medium text-body/60 line-through">{{ $item->human_old_price }} р.</span>
                            @endif
                        </span>
                    </label>
                </div>
            @endforeach
        </div>
    @endif
</div>
