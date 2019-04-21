<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function participant(){
         return $this->belongsToMany('App\Event', 'event_participant', 'participant', 'event');
    }

    public function organizer(){
        return $this->belongsToMany('App\Event', 'event_organizer', 'organizer', 'event');
    }

    public function member(){
         return $this->belongsToMany('App\Group', 'group_member');
    }

    public function moderator(){
        return $this->belongsToMany('App\Group', 'group_moderator');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function votes(){
        return $this->hasMany('App\Vote');
    }

    /**
     * The cards this user owns.
     */
    public function cards() {
        return $this->hasMany('App\Card');
    }

}
