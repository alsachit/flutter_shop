<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'wish_list'];

    public function costomer() {
        return $this->belongsTo(User::class);
    }
}
