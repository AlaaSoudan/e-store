<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_date',
        'order_number',
        'customer_id',
        'total_amount',
    ];

     protected $casts = [
        'order_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
public function items(): HasMany
{
    return $this->hasMany(OrderItem::class);
}
public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

}
