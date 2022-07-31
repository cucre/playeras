<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventorySummary extends Model {
    protected $fillable = [
        'product_id', 'stock', 'created_by',
    ];

    public function product() {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}