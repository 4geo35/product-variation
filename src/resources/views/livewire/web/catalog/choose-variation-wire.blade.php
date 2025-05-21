<div>
    @if ($variation)
        <div class="flex items-end space-x-indent-half mb-indent">
            <div class="text-5xl font-semibold">{{ $variation->human_price }} руб</div>
            @if ($variation->sale)
                <div class="text-3xl font-semibold text-secondary line-through">{{ $variation->human_old_price }} руб</div>
            @endif
        </div>
    @endif
    @if ($variations->count() > 1)
        <div class="space-y-indent-half">
            @foreach($variations as $item)
                <div class="form-check">
                    <input class="form-check-input" id="productVariation-{{ $item->sku }}"
                           type="radio" name="productVariation" value="{{ $item->id }}" wire:model.live="variationId">
                    <label class="form-check-label flex items-center space-x-indent" for="productVariation-{{ $item->sku }}">
                        <span>{{ $item->title }}</span>
                        <span class="flex items-center justify-start space-x-indent-half">
                            <span class="text-xl font-semibold">{{ $item->human_price }} руб</span>
                            @if ($item->sale)
                                <span class="font-semibold text-secondary line-through">{{ $item->human_old_price }} руб</span>
                            @endif
                        </span>
                    </label>
                </div>
            @endforeach
        </div>
    @elseif (! $variations->count())
        <div>Нет цен</div>
    @endif
</div>
