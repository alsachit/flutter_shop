<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'countries';

    public function states() {
        return $this->hasMany(State::class);
    }

    public function cities() {
        return $this->hasMany(City::class);
    }
}
