<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'brand', 'created_by',
    ];

    public function setBrandAttribute($brand) {
        $this->attributes['brand'] = strtoupper($brand);
    }
}