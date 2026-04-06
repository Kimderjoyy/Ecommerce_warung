<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'payment_proof',
        'payment_due',
        'payment_code',
        'shipping_address',
        'shipping_phone',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'payment_due' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = date('Ymd');
        $lastOrder = self::whereDate('created_at', today())->count();
        $number = $lastOrder + 1;
        return $prefix . $date . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}