<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestCartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'guest_cart_id',
        'product_id',
        'quantity',
    ];

    /**
     * Get the guest cart that owns the item.
     */
    public function cart()
    {
        return $this->belongsTo(GuestCart::class, 'guest_cart_id');
    }

    /**
     * Get the product that the item refers to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
