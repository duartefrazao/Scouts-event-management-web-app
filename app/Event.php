<?php

namespace App;


use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


class Event extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

 
    public function participants() {
        return $this->belongsToMany('App\User', 'event_participant', 'event', 'participant');
    }

    public function groups(){
        return $this->belongsToMany('App\Group', 'event_group', 'event', 'group');
    }


    public function organizers() {
        return $this->belongsToMany('App\User', 'event_organizer', 'event', 'organizer');
    }

    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function comments(){
        return $this->hasMany('App\Comments');
    }

    public function poll(){
        return $this->hasOne('App\Poll');
    }

    public function addComment($text){

        $event = $this->id;
        $user = auth()->id();
    

        return Comment::create([
            'participant'=>$user,
            'event' => $event,
            'text'=>$text,
            ]);   
    }
}
