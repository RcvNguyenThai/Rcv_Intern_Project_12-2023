<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Image model to contain the image information for the product
 *
 * 27/12/2023
 * version:1
 */
class Image extends Model
{
    use HasFactory;

    protected $fillable = ['img_name', 'img_extension', 'img_url', 'product_id'];

    /**
     * Retrieves the associated Product model for this instance.
     *
     * @return BelongsTo The associated Product model.
     * 27/12/2023
     * version:1
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
