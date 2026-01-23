<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'image_url',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getDisplayUrlAttribute()
    {
        if (str_starts_with($this->image_url, 'http')) {
            return $this->image_url;
        }
        return \Illuminate\Support\Facades\Storage::url($this->image_url);
    }
}
