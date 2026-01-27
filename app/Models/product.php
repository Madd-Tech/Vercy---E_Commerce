<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','slug','description','price','status','created_by', 'image'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    // public function stock()
    // {
    //     return $this->hasOne(Stock::class);
    // }

    // public function images()
    // {
    //     return $this->hasMany(ProductImage::class);
    // }
}

