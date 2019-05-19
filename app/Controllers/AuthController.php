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
    public function getTokenUserID(Request $request, Response $response)
    {
        $token = $request->getAttribute('oauth_access_token');
        try {
            $id = AuthService::getTokenUserID($token);
        }catch (\Exception $exception){
            return $response->withStatus(400);
        }
        return $response->withJson($id);
    }
}