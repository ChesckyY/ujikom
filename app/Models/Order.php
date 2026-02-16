<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'product_id', 
        'name', 
        'email', 
        'address', 
        'notes', 
        'total_item', 
        'total_price',
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relasi ke User (jika ada tabel users)
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}