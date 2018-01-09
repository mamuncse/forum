<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{


    public function getRouteKeyName()
    {
        return 'slug'; // TODO: Change the autogenerated stub
    }


    public function threads()
    {
        $this->hasMany(Thread::class);
    }
}