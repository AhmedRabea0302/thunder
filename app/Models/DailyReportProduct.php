<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReportProduct extends Model
{
    use HasFactory;

    public function getProductDetails() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
