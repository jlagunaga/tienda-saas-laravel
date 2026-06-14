<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\ContactMessage;

class Store extends Model
{
    use HasFactory;

    protected $fillable = 
        ['name', 
        'slug', 
        'user_id',
        'description',
        'address',
        'whatsapp_number',
        'facebook_url',
        'instagram_url',
        'logo_path',
        'banner_path',
        'contact_email',
        'notify_new_order',
        'payment_instructions',
        'bank_name',
        'bank_account',
        'bank_cci',
        'bank_holder',
        'yape_qr_path',
        'yape_phone',
        'plin_qr_path',
        'plin_phone',
        ];

    protected $casts = [
        'notify_new_order' => 'boolean', 
    ];

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

    public function contactMessages():HasMany{
        return $this->hasMany(ContactMessage::class);
    }

}
