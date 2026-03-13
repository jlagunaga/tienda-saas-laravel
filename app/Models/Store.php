<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
    public function categories():HasMany{
        return $this->hasMany(Category::class);
    }

    public function products():HasMany{
        return $this->hasMany(Product::class);
    }

    public function orders():HasMany{
        return $this->hasMany(Order::class);
    }
}
