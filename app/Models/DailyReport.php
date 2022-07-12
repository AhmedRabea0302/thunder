<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    public function getDailyReportProducts() {
        return $this->hasMany(DailyReportProduct::class, 'daily_report_id');
    }

    public function getHealthyStockDetails() {
        return $this->hasOne(Stock::class, 'id','healthy_stock_delivery_id');
    }

    public function getCorruptedStockDetails() {
        return $this->hasOne(Stock::class, 'id', 'corrupt_stock_delivery_id');
    }
}
