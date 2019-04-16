<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventParticipant extends Pivot
{

    public function participant(){
        return $this->belongsTo('App\User');
    }

    public function event(){
        return $this->belongsTo('App\Event');
    }
}
