<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The table associated with the model.
     */
    protected $table = 'file';
}
