<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The card this item belongs to.
     */
    public function event() {
        return $this->belongsTo('App\Event');
    }


    public function participant() {
        return $this->belongsTo('App\User');
    }

}
