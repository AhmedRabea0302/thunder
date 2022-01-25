<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeProduct extends Model
{
    use HasFactory;

    protected $fillable = ['product_tree_id', 'product_id', 'quantity', 'wasted_quantity', 'total_quantity'];

    public function getProductDetails() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
