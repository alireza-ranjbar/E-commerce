<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $guarded = [];
    protected $appends = ['is_active'];

    public function attributes(){
        return $this->belongsToMany(Attribute::class);
    }

    public function parent(){
        return $this->belongsTo(Category::class , 'parent_id');
    }

    public function children(){
        return $this->hasMany(Category::class , 'parent_id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function getIsActiveAttribute($is_active){
        return $is_active ? 'فعال' : 'غیرفعال' ;
    }
}
