<?php

namespace GIS\ProductVariation\Interfaces;

use ArrayAccess;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JsonSerializable;
use Stringable;
use Illuminate\Contracts\Broadcasting\HasBroadcastChannel;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\CanBeEscapedWhenCastToString;
use Illuminate\Contracts\Support\Jsonable;

interface OrderStateInterface extends Arrayable, ArrayAccess, CanBeEscapedWhenCastToString, HasBroadcastChannel,
    Jsonable, JsonSerializable, QueueableEntity, Stringable, UrlRoutable
{
    public function orders(): HasMany;
    public function fixKey($updating = false): void;
}
