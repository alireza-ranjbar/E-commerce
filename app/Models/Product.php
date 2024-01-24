<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Brand;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductRates;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'products';
    protected $guarded = [];
    protected $appends = ['price_check','sale_check','is_active'];

    public function sluggable(): array{
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    //Accessors
    public function getIsActiveAttribute($is_active){
        return $is_active ? 'فعال' : 'غیرفعال' ;
    }

    public function getPriceCheckAttribute(){
        return $this->productVariations()->where('quantity','>',0)->orderBY('price')->first() ?? false;
    }

    public function getSaleCheckAttribute(){
        return $this->productVariations()->where('quantity','>',0)->where('sale_price','!=',null)->where('date_on_sale_from','<',now())->where('date_on_sale_to','>',now())->orderBy('sale_price')->first() ?? false;
    }

    //relationshpis
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function productAttributes(){
        return $this->hasMany(ProductAttribute::class);
    }

    public function productVariations(){
        return $this->hasMany(ProductVariation::class);
    }

    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }

    public function productRates(){
        return $this->hasMany(ProductRates::class);
    }

    //Scopes
    public function scopeAttributeFilter($query){
        if(request()->has('attribute')){
            foreach(request()->attribute as $attributeItem){
                $query->whereHas('productAttributes',function($query) use($attributeItem){
                    foreach(explode('-',$attributeItem) as $index => $value)
                    if ($index == 0) {
                        $query->where('value', $value);
                    } else {
                        $query->orWhere('value', $value);
                    }
                });
            }
        }

        return $query;
    }

    public function scopeVariationFilter($query){
        if(request()->has('variation')){
            $query->whereHas('productVariations' , function($query) {
                foreach(explode('-', request()->variation) as $index => $value){
                    if($index == 0){
                        $query->where('value' , $value);
                    }else{
                        $query->orWhere('value' , $value);
                    }
                }

            });
        }

        return $query;
    }

    public function scopeSortFilter($query){
        if (request()->has('sort')) {
            $sort = request()->sortBy;
            switch ($sort) {
                case 'max':
                    $query->orderByDesc(ProductVariation::select('price')->whereColumn('product_variations.product_id', 'products.id')->orderBy('sale_price', 'desc')->take(1));
                    break;
                case 'min':
                    $query->orderBy(ProductVariation::select('price')->whereColumn('product_variations.product_id', 'products.id')->orderBy('sale_price', 'desc')->take(1));
                    break;
                case 'latest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                default:
                    $query;
                    break;
            }
        }

        return $query;
    }

    public function scopeSearchFilter($query){
        if(request()->has('search')){
            $keyword = trim(request()->search);
            if($keyword != ''){
                $query->where('name', 'LIKE' , '%'.$keyword.'%');
            }
        }

        return $query;
    }

}
