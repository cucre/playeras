<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Talla extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'talla', 'created_by',
    ];

    public function setTallaAttribute($talla) {
        $this->attributes['talla'] = strtoupper($talla);
    }
}
