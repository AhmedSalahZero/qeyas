<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    public $timestamps = false;
    protected $table = 'password_resets';
    protected $fillable =
        [
            'phone','code','expire_at'
        ];
}
