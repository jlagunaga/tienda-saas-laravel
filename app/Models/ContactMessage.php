<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Store;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'name',
        'email',
        'phone',
        'message',
        'subject',
        'is_read',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
