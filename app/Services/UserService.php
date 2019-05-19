<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 22.04.19
 * Time: 23:10
 */

namespace App\Services;


use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;

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

    public static function getUserByUsername($username): User
    {
        $user = User::where('username', $username)->firstOrFail();
        return $user;
    }

    public static function getAllUsers(): Collection
    {
        $users = User::all();
        return $users;
    }

    public static function createUser($username): User
    {
        $user = new User();
        $user->username = $username;
        $user->save();
        return $user;
    }

    public static function createUserWithOAuth($token, $username, $oauthid)
    {
        AuthService::verifyAccessToken($token);
        $user = self::createUser($username);
        AuthService::addOAuthAssoc($user->id, $oauthid);
    }


}