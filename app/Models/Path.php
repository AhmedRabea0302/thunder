<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    use HasFactory;

    protected $fillable = ['sector_id', 'product_id', 'path_code', 'path_type', 'path_quantity', 'piece_total_budget'];

}
