<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestCart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'session_id',
        'email',
        'name',
        'phone',
        'address',
        'city',
        'state',
        'zipcode',
        'notes',
    ];

    /**
     * Get the cart items for the guest cart.
     */
    public function items()
    {
        return $this->hasMany(GuestCartItem::class);
    }
}
