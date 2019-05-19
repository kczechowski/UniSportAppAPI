<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 11.05.19
 * Time: 19:02
 */

namespace App\Services;


use GuzzleHttp\Client;
use Illuminate\Database\Capsule\Manager as Capsule;

class AuthService
{
    public static function verifyAccessToken($token)
    {
        if (empty($token)) {
            throw new \Exception("No Authorization header");
        }
        $client = new Client();
        $response = $client->request('POST', $_ENV['AUTH_API_URL'] . '/token/verify', [
            'headers' => [
                'Authorization' => $token
            ]
        ]);
    }

    public static function getTokenUserID($token)
    {

        $authInfo = self::getOAuthUserInfo($token);

        if (!isset($authInfo))
            throw new \Exception('No authorization header');

        $query = Capsule::table('oauth_users')
            ->select('oauth_users.user_id')
            ->where('oauth_users.oauth_id', $authInfo['client_id']);

        $result = $query->get();
        $result = $result->toArray();

        if (count($result) === 0)
            throw new \Exception('User not found');

        return ['user_id' => $result[0]->user_id];

    }

    public static function getOAuthUserInfo($token): array
    {
        $client = new Client();
        $response = $client->request('GET', $_ENV['AUTH_API_URL'] . '/user', [
            'headers' => [
                'Authorization' => $token
            ],
        ]);
        $data = json_decode($response->getBody(), true);
        return $data;
    }

    public static function isAccessTokenOwnedByUser($userID, $token): bool
    {

        $authInfo = self::getOAuthUserInfo($token);

        $query = Capsule::table('oauth_users')
            ->select('oauth_users.oauth_id')
            ->where('oauth_users.user_id', $userID);

        $result = $query->get();
        $result = $result->toArray();

        if (count($result) === 0)
            return false;

        if ($authInfo['client_id'] === $result[0]->oauth_id)
            return true;

        return false;
    }

    public static function addOAuthAssoc($userID, $oauthID)
    {
        Capsule::table('oauth_users')
            ->insert([
                'user_id' => $userID,
                'oauth_id' => $oauthID,
            ]);
    }
}