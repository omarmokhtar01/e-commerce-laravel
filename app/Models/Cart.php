<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{ 
    use HasFactory;
    protected $fillable = [
        'user_id',
        'quantity',
        'price',
        'product_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
        }
        public function product()
        {
            return $this->belongsTo(Product::class,'product_id');
            }
}
