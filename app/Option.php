<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'option';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The poll this option belongs to.
     */
    public function poll(){
        return $this->belongsTo('App\Poll');
    }

}
