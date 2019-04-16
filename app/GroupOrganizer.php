<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupOrganizer extends Pivot
{

    public function organizer(){
        return $this->belongsTo('App\User');
    }

    public function group(){
        return $this->belongsTo('App\Group');
    }
}

