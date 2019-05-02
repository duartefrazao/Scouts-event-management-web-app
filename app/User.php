<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Authenticatable implements AuthenticatableContract,CanResetPasswordContract
{
    use Notifiable;
    use AuthenticableTrait,CanResetPassword;
    use ValidatesRequests;

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
        'email', 'password', 'name', 'birthdate', 'guardian', 'is_responsible', 'is_guardian', 'description', 'deactivated', 'vector'
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
        return $this->belongsToMany('App\Group', 'group_member', 'member', 'group');
    }

    public function moderator(){
        return $this->belongsToMany('App\Group', 'group_moderator', 'moderator', 'group');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function votes(){
        return $this->hasMany('App\Vote');
    }

    public function guardian(){
        return $this->belongsTo('App\User');
    }


}
