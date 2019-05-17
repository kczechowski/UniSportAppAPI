<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 11.05.19
 * Time: 19:02
 */

namespace App\Services;


use GuzzleHttp\Client;

class AuthService
{
    public static function getAccessToken($username, $password, $scope = "")
    {
        $client = new Client();
        $response = $client->request('POST', $_ENV['AUTH_API_URL'] . '/token', [
            'headers' => [
                'content_type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $username,
                'client_secret' => $password,
                'scope' => $scope
            ]
        ]);
        $token = json_decode($response->getBody(), true);
        return $token;
    }
}