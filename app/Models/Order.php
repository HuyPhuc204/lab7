<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $dates = ['order_date'];
    protected $fillable = ['customer_id', 'order_date', 'total_price'];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_date = now();
        });
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function product(){
        return $this->belongsToMany(Product::class , 'order_details', 'order_id', 'product_id')->withPivot('price', 'quantity');
    }
}
