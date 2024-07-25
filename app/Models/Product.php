<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['supplier_id', 'product_name', 'description', 'price', 'quantity'];
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function order(){
        return $this->belongsToMany(Order::class);
    }

}
