<?php
namespace Abishekrsrikaanth\TwoCheckout\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Request
{
    private function send($method, $requestType, $data)
    {
        try {
            $headers = [
                'Content-Type' => 'application/json',
                'User-Agent' => 'PHP-MAILCHIMP/1.0',
            ];

            $auth = ['apikey', $this->_apiKey];

            $response = null;
            switch ($requestType) {
                case "GET":
                    break;
                case "POST":
                    $response = $this->_client->post($method, ['auth' => $auth, 'headers' => $headers, 'json' => $data]);
                    break;
                case "PATCH":
                    break;
                case "DELETE":
                    break;
            }

            return ['status' => 'SUCCESS', 'data' => $response];
        } catch (ClientException $ex) {
            $response = $ex->getResponse();
            $responseString = json_decode($response->getBody()->getContents(), true);
            $responseString = $responseString['detail'];

            return ['status' => 'ERROR', 'message' => $responseString];
        }
    }
}