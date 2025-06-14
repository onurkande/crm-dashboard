<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaultyProduct extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'description',
        'error_type',
        'status',
        'admin_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
} 