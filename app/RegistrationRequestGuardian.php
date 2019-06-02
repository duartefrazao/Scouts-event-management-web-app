<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ImageTrait;

class RegistrationRequestGuardian extends Model
{
    use ImageTrait;

    protected $fillable = ['minor','g_name', 'g_email','g_birthdate', 'g_password','g_description'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registration_request_guardian';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $primaryKey = 'minor';

}
