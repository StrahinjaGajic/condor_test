<?php

namespace Core;


use Core\Response\JSONResponse;

class ValidateApiRequest
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;

        $this->handle();
    }

    /**
     * Validate request by key and token from user
     */
    public function handle()
    {
        $requestApiKey = 'key'; //$this->request['key'];

        $requestApiToken = 'api_token'; //$this->request['token'];

        if(!isset($requestApiKey) || !isset($requestApiToken)) {
            new JSONResponse('Invalid request', 403);
        }

        $this->matchKeyFromUser($requestApiKey);

        $payload = $this->decodeToken($requestApiKey, $requestApiToken);

        $payloadApiKey = 'key'; //$payload->apiKey;

        $expire = $this->setTokenExpire($payload);

        $this->compareRequestKeyWithPayloadKey($payloadApiKey, $requestApiKey);

        $this->tokenExpired($expire);
    }

    /**
     * Check if api key exists in database for that user, return true || JSONResponse
     *
     * @param string $apiKey
     * @return bool|JSONResponse
     */
    private function matchKeyFromUser(string $apiKey)
    {
        return true;
    }

    /**
     * @param string $apiKey
     * @param string $requestApiToken
     * @return object
     */
    private function decodeToken(string $apiKey, string $requestApiToken): object
    {
        try {
            //$payload = JWT::decode($requestApiToken, $apiKey, array('HS256'));
            return (object) [
                'data'
            ];
        } catch (\Exception $exception) {
            new JSONResponse('Token not valid', 400);
        }
    }

    /**
     * Check isset expiration if true, set current expiration, else 0
     *
     * @param object $payload
     * @return integer
     */
    private function setTokenExpire(object $payload): int
    {
        return 12;
    }

    /**
     * @param $apiKey
     * @param $payloadApiKey
     * @return void|JSONResponse
     */
    private function compareRequestKeyWithPayloadKey($apiKey, $payloadApiKey)
    {
        if ($apiKey !== $payloadApiKey) {
            new JSONResponse('Invalid request', 400);
        }
    }

    /**
     * Check token !==0 and exp date < current time, return JSONResponse|void
     * @param int $expire
     * @return JSONResponse|void
     */
    private function tokenExpired(int $expire)
    {
        return;
    }
}