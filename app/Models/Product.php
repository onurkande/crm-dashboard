<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'producer',
        'importer',
        'product_code',
        'image',
        'target_lang',
        'original_lang',
        'translated_text',
        'barcode_type',
        'barcode',
        'qr_code',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function translation(): HasOne
    {
        return $this->hasOne(ProductTranslation::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function faultyProducts()
    {
        return $this->hasMany(FaultyProduct::class);
    }
} 