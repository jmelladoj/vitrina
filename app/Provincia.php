<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provincia extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id' ];

    protected $dates = ['deleted_at'];

    public function comunas(){
        return $this->hasMany(Comuna::class, 'provincia_id');
    }
}
