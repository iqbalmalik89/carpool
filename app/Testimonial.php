<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Testimonial extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'pic_path', 'status'
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
