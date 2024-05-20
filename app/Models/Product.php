<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'price',
        'description',
        'category_id',
        'brand_id',
        'quantity',
        'discount',
        'amount',
        'is_avaliable',
        'is_trendy',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }
}
