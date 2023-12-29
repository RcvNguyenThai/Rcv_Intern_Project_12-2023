<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Product model to contain the group type for user
 *
 * 27/12/2023
 * version:1
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'product_name', 'description', 'price', 'status', 'user_id'];

    public $incrementing = false;
    public $keyType = 'string';

    /**
     * Retrieve the associated user of this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 27/12/2023
     * version:1
     */
    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class);
    }

    /**
     * Retrieve the images associated with this object.
     *
     * @return HasMany The images associated with this object.
     * 27/12/2023
     * version:1
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }


}
