<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Store;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image_path',
        'stock',
        'category_id',
        'store_id',
    ];
// un producto pertenece a una tienda
public function store(): BelongsTo
{
    return $this->belongsTo(Store::class);
}
// un producto pertenece a una categoria
public function category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}
    
}
