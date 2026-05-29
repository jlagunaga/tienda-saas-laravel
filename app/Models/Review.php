<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product;
use App\Models\Customer;


class Review extends Model
{
    use HasFactory;

protected $fillable = ['product_id','customer_id','rating','comment','is_visible'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function customer()
    {
      return $this->belongsTo(Customer::class);
    } 
    

}
