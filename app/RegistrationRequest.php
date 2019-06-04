<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ImageTrait;

class RegistrationRequest extends Model
{
    use ImageTrait;

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
