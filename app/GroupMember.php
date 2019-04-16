<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupMember extends Pivot
{
    public function member(){
        return $this->belongsTo('App\User');
    }

    public function group(){
        return $this->belongsTo('App\Group');
    }
}

