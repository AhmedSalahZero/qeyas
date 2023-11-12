<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public function getValueAttribute($value)
    {
        return $value ? $value : '';
    }


    public function getDetailsAttribute($value)
    {
        return $value ? $value : '';
    }
}
