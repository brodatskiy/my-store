<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\HttpFilter;
use Orchid\Screen\AsSource;


/**
 *
 *
 * @property int $id
 * @property string $storage_id
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, CartItem> $cartItems
 * @property-read int|null $cart_items_count
 * @property-read User|null $user
 * @method static Builder<static>|Cart defaultSort(string $column, string $direction = 'asc')
 * @method static Builder<static>|Cart filters(?mixed $kit = null, ?HttpFilter $httpFilter = null)
 * @method static Builder<static>|Cart filtersApply(iterable $filters = [])
 * @method static Builder<static>|Cart filtersApplySelection($class)
 * @method static Builder<static>|Cart newModelQuery()
 * @method static Builder<static>|Cart newQuery()
 * @method static Builder<static>|Cart query()
 * @method static Builder<static>|Cart whereCreatedAt($value)
 * @method static Builder<static>|Cart whereId($value)
 * @method static Builder<static>|Cart whereStorageId($value)
 * @method static Builder<static>|Cart whereUpdatedAt($value)
 * @method static Builder<static>|Cart whereUserId($value)
 * @mixin Eloquent
 */
class Cart extends Model
{
    use AsSource, Filterable, Attachable;

    protected $table = 'carts';

    protected $fillable = [
        'storage_id',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'cart_items', 'cart_id', 'product_id')
            ->withPivot('quantity');
    }
}
