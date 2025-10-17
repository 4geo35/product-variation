@php($moreVariations = $variations->count() - 1)

<div class="{{ $moreVariations >= 0 ? 'mt-indent-half' : '' }}">
    @if ($variation)
        <div class="flex flex-wrap items-end">
            <div class="text-lg lg:text-2xl font-semibold mr-indent-half lg:mb-1.5">{{ $variation->human_price }} руб</div>
            @if ($variation->sale)
                <div class="lg:text-lg font-medium text-body/60 line-through lg:mb-1.5">{{ $variation->human_old_price }} руб</div>
            @endif
        </div>
    @endif
    @if ($variation && $moreVariations)
        <div class="-mt-1.5 relative" x-data="{ show: false }">
            <div class="inline-flex items-center font-semibold text-primary hover:text-primary-hover cursor-pointer py-1.5"
                 @click="show = true" @click.outside="show = false">
                <div class="text-nowrap truncate">{{ $variation->title }}</div>
                <x-tt::ico.arrow-down class="ml-2" />
            </div>
            <div class="select-variation py-2 absolute min-w-[150px] max-w-[300px] max-h-[200px] rounded-base bg-white shadow-lg border border-stroke beautify-scrollbar overflow-y-auto"
                 style="display: none" x-show="show" x-transition>
                @foreach($variations as $item)
                    <div class="group">
                        <input class="hidden peer" id="productVariation-{{ $item->sku }}"
                               type="radio" name="productVariation" value="{{ $item->id }}" wire:model.live="variationId">
                        <label class="flex items-center justify-between w-full px-indent-half py-1.5 text-sm font-semibold hover:bg-primary/5 cursor-pointer peer-checked:bg-primary/5 peer-checked:text-body/60 peer-checked:after:content-['✓'] peer-checked:after:ml-indent-half"
                               for="productVariation-{{ $item->sku }}" @click="show = false">
                            <span class="text-nowrap truncate">{{ $item->title }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
