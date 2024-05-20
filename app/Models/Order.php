<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_price',
        'payment_method',
        'status',
        'location_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function location(){
        return $this->belongsTo(Location::class,'location_id');
    }
}
