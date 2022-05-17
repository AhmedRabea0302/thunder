<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    use HasFactory;

    protected $fillable = ['sector_id', 'product_id', 'path_code', 'path_type', 'path_quantity', 'piece_total_budget'];

    public function getPathMainProduct() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getPathSector() {
        return $this->hasOne(Sector::class, 'id', 'sector_id');
    }

    public function getPathExpenses() {
        return $this->hasMany(PathExpense::class, 'path_id', 'id');
    }

    public function getPathSteps() {
        return $this->hasMany(PathStep::class, 'path_id', 'id');
    }
}
