<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'states';

    public function country() {
       return $this->belongsTo(Country::class);
    }

    public function cities() {
       return $this->hasMany(City::class);
    }
}
