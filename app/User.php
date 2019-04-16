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
         return $this->belongsToMany('App\Event')->using('App\EventParticipant');
    }

    public function organizer(){
        return $this->belongsToMany('App\Event')->using('App\EventOrganizer');
    }

    public function member(){
         return $this->belongsToMany('App\Group')->using('App\GroupMember');
    }

    public function moderator(){
        return $this->belongsToMany('App\Group')->using('App\GroupModerator');
    }

    /**
     * The cards this user owns.
     */
    public function cards() {
        return $this->hasMany('App\Card');
    }

}
