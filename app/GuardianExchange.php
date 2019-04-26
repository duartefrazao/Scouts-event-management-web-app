<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuardianExchange extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'guardian_exchange';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The card this item belongs to.
     */
    public function minor() {
        return $this->belongsTo('App\User','minor');
    }


    public function new_guardian() {
        return $this->belongsTo('App\User', 'new_guardian');
    }

}
