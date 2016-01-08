<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Email extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'template_name', 'subject', 'template', 'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //'password', 'remember_token',
    ];
}
