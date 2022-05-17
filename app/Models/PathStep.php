<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathStep extends Model
{
    use HasFactory;
    protected $fillable = ['equipment_id', 'step_type', 'workers_number', 'worker_hour_pay', 'production_time_rate', 'step_total_budget'];


    public function equipmentDetails() {
        return $this->hasOne(Equipment::class, 'id', 'equipment_id');
    }

    public function stepExpenses() {
        return $this->hasMany(PathExpense::class, 'equipment_id', 'equipment_id');
    }
}
