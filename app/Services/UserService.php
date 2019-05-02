<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 22.04.19
 * Time: 23:10
 */

namespace App\Services;


use App\Models\User;

class UserService
{

    public static function isUserExists($id): bool
    {
        $user = User::find($id);
        return ($user === null) ? false : true;
    }

    public static function getUserById($id): User
    {
        $user = User::findOrFail($id);
        return $user;
    }
}