<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTranslation extends Model
{
    protected $fillable = [
        'product_id',
        'design_translated_text'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
} 