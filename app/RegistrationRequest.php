<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationRequest extends Model
{

    protected $fillable = ['id','name', 'email','birthdate', 'password','description'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registration_request';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

}
