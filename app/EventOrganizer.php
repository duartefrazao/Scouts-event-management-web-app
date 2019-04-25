<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventOrganizer extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = 'event_organizer';
}
