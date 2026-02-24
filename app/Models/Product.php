<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'original_price', 'discount', 'image', 'display_images', 'stock', 'low_stock_threshold', 'track_inventory', 'category', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function stockHistory()
    {
        return $this->hasMany(StockHistory::class);
    }

    public function isLowStock()
    {
        return $this->track_inventory && $this->stock <= $this->low_stock_threshold;
    }

    public function isOutOfStock()
    {
        return $this->track_inventory && $this->stock <= 0;
    }

    public function hasStock($quantity = 1)
    {
        return !$this->track_inventory || $this->stock >= $quantity;
    }
}
