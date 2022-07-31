<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryDetail extends Model {
	protected $fillable = [
        'product_id', 'quantity', 'movement_type', 'sale_type', 'vendedor_id', 'created_by',
    ];

    public function product() {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }

    public function vendedor() {
        return $this->belongsTo('App\User', 'vendedor_id', 'id');
    }
}