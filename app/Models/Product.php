<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function discounts()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function getPriceWithDiscount()
    {
        if ($this->discounts) {
            $discount = $this->discounts->percentage;
            return $this->price - ($this->price * $discount / 100);
        }
        return $this->price;
    }
}
