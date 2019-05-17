<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 11.05.19
 * Time: 19:00
 */

namespace App\Controllers;


use App\Services\AuthService;
use GuzzleHttp\Exception\RequestException;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        $params = $request->getParams();
        $scopes = array_key_exists('scope', $params) ? $params['scope'] : null;
        try {
            if (isset($scopes))
                $token = AuthService::getAccessToken($params['username'], $params['password'], $scopes);
            else
                $token = AuthService::getAccessToken($params['username'], $params['password']);
        } catch (RequestException $e) {
            return $response->withStatus(400);
        }
        return $response->withJson($token);
    }
}