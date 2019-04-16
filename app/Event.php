<?php

namespace App;

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

    /**
     * The card this item belongs to.
     */
    public function participants() {
        return $this->belongsTo('App\User');
    }
}
