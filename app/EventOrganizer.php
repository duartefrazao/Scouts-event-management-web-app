<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventOrganizer extends Pivot
{
    public function organizer(){
        return $this->belongsTo('App\User');
    }

    public function event(){
        return $this->belongsTo('App\Event');
    }
}

