<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param int $id
     * @param Request $request
     * @return bool
     */
    public static function updateUserData(int $id, Request $request) :bool
    {
        $user = User::where('id', $id)
            ->update(['first_name' => $request->first_name, 'second_name' => $request->second_name, 'phone' => $request->phone]);
        return $user;
    }
}
