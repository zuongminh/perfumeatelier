<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamp = false;
    protected $fillable = ['idCategory','idBrand','QuantityTotal','ProductName','ProductSlug','DesProduct','ShortDes','Price','Sold','StatusPro','created_at'];
    protected $primaryKey = 'idProduct';
    protected $table = 'product';

    // public function category(){
    //     return $this->belongsTo('App\Models\Category','idCategory');
    // }

    // public function brand(){
    //     return $this->belongsTo('App\Models\Brand','idBrand');
    // }

    // public function productimage(){
    //     return $this->hasOne('App\Models\ProductImage','idProduct');
    // }
}
