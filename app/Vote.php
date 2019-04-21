<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vote';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The users that voted
     */
    public function voter(){
        return $this->belongsToMany('App\User');
    }

    public function option(){
        return $this->belongsTo('App\Option');
    }
}