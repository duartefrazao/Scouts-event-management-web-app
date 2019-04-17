<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'location';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The card this item belongs to.
     */
    public function event(){
        return $this->hasMany('App\Event');
    }
}
