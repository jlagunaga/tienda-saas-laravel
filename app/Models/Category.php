<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    // Campos que permitimos llenar
    protected $fillable =['store_id','name','slug'];
    
    // Relación: Una categoría pertenece a una tienda
    public function store():BelongsTo{
        return $this->belongsTo(Store::class);
    }

    public function products():HasMany{
        return $this->hasMany(Product::class);
    }

}
