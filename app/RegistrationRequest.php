<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class RegistrationRequest extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registration_request';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

}
