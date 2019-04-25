<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group';


    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The group members
     */
    public function members() {
        return $this->belongsToMany('App\User', 'group_member', 'group', 'member');
    }


    public function moderators() {
        return $this->belongsToMany('App\User', 'group_moderator', 'group', 'moderator');
    }

    public function events(){
        return $this->belongstoMany('App\Event', 'event_group', 'group', 'event');
    }

}
