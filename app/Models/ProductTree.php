<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTree extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'product_tree_code', 'product_tree_type', 'quantity', 'total_budget'];

    public function prouctTreeProucts() {
       return $this->hasMany(TreeProduct::class, 'product_tree_id', 'id');
    }

    public function getTreeMainProduct() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}
