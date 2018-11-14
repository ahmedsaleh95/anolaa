<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //
        protected $guarded = [];

        #get user of message
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
