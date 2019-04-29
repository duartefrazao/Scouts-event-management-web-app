<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = 'event_participant';
}
