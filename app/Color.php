<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'color', 'created_by', 
    ];

    public function setColorAttribute($color)
    {
        $this->attributes['color'] = strtoupper($color);
    }
}
