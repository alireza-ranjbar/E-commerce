<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $guarded = [];

    public function getStatusAttribute($stats){
        if($stats == 0){
            $stats = 'سفارش ناموفق';
        }else{
            $stats = 'سفارش موفق';
        }
        return $stats;
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
