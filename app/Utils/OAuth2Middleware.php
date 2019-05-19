<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 11.05.19
 * Time: 16:05
 */

namespace App\Utils;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Lcobucci\JWT\Parser;
use Slim\Http\Request;
use Slim\Http\Response;

class OAuth2Middleware
{

    private $scopes = [];

    public function __invoke(Request $request, Response $response, callable $next)
    {
        try {
            $request = $this->verifyAccessToken($request);
        } catch (\Exception $exception) {
            return $response->withStatus(401, $exception->getMessage());
        }
        return $next($request, $response);
    }

    public function __construct()
    {

    }

    private function verifyAccessToken(Request $request)
    {
        $token = $request->getHeader('Authorization');
        if (empty($token)) {
            throw new \Exception("No Authorization header");
        }

        try {
            $client = new Client();
            $response = $client->request('POST', $_ENV['AUTH_API_URL'] . '/token/verify', [
                'headers' => [
                    'Authorization' => $token
                ]
            ]);
        } catch (RequestException $exception) {
            throw $exception;
        }

        $formattedToken = trim(preg_replace('/^(?:\s+)?Bearer\s/', '', $token[0]));

        $jwt = (new Parser())->parse($formattedToken);

        if(!$this->verifyScopes($jwt->getClaim('scopes')))
            throw new \Exception('Invalid scopes');

            return $request
                ->withAttribute('oauth_access_token', $token)
                ->withAttribute('oauth_access_token_id', $jwt->getClaim('jti'))
                ->withAttribute('oauth_client_id', $jwt->getClaim('aud'))
                ->withAttribute('oauth_user_id', $jwt->getClaim('sub'))
                ->withAttribute('oauth_scopes', $jwt->getClaim('scopes'));
    }

    private function setScopes(array $scopes)
    {
        $this->scopes = $scopes;
    }

    public function withScopes(array $scopes)
    {
        $cloned = clone $this;
        $cloned->setScopes($scopes);
        return $cloned;
    }

    private function verifyScopes(array $tokenScopes){
        if (count($this->scopes) > 0) {
            return (
                is_array($tokenScopes)
                && count($tokenScopes) == count($this->scopes)
                && array_diff($tokenScopes, $this->scopes) === array_diff($this->scopes, $tokenScopes)
            );
        }
        return true;
    }
}