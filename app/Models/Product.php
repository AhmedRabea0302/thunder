<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function getProductTrees()
    {
        return $this->hasMany(ProductTree::class, 'product_id', 'id');
    }

    public function getProductPaths() {
        return $this->hasMany(Path::class, 'product_id', 'id');
    }

}
