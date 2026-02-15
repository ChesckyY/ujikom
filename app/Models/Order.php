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

    // Relasi ke Product untuk menampilkan nama produk di tabel admin 
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}