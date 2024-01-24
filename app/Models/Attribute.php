<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'attributes';

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function attributesValues(){
        return $this->hasMany(ProductAttribute::class)->select('attribute_id','value')->distinct();
    }

    public function variationValues(){
        return $this->hasMany(ProductVariation::class)->select('value')->distinct();
        //return $this->hasMany(ProductVariation::class)->select('value')->distinct();
    }


}
