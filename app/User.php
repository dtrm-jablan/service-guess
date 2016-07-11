<?php namespace Determine\Service\Guess;

use Illuminate\Foundation\Auth\User as AuthUser;

class User extends AuthUser
{
    /** @inheritdoc */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /** @inheritdoc */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
