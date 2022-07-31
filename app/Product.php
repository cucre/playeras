<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product', 'sku', 'description', 'brand_id', 'color_id', 'talla_id', 'gender', 'path_image', 'purchase_price', 'selling_price', 'customer_price', 'created_by',
    ];

    public function brand() {
        return $this->belongsTo('App\Brand', 'brand_id', 'id');
    }

    public function color() {
        return $this->belongsTo('App\Color', 'color_id', 'id');
    }

    public function talla() {
        return $this->belongsTo('App\Talla', 'talla_id', 'id');
    }

    public function inventory_summary() {
        return $this->belongsTo('App\InventorySummary', 'id', 'product_id');
    }

    public function setProductAttribute($product) {
        $this->attributes['product'] = strtoupper($product);
    }

    public function setGenderAttribute($gender) {
        $this->attributes['gender'] = strtoupper($gender);
    }
}