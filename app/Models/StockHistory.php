<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    protected $table = 'stock_history';
    
    protected $fillable = [
        'product_id',
        'quantity_change',
        'stock_before',
        'stock_after',
        'type',
        'reference_type',
        'reference_id',
        'user_id',
        'notes'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
