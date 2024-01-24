<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariation extends Model
{
    use HasFactory;

    protected $table = 'product_variations';
    protected $guarded = [];
    protected $appends = ['sale_check','discount_percent'];

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }

    public function getSaleCheckAttribute(){
        return ($this->sale_price != null && $this->date_on_sale_from < now() && $this->date_on_sale_to > now()) ? true : false;
    }

    public function getDiscountPercentAttribute(){
        return $this->sale_check ? round((($this->price - $this->sale_price)/$this->price)*100) : null;
    }

}
