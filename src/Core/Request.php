<?php
namespace Abishekrsrikaanth\TwoCheckout\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class Request
{
    private $_sandbox = false;
    private $_sellerId = '';
    private $_privateKey = '';
    private $_userName = '';
    private $_password = '';
    private $_module = '';
    private $_userData = '';
    private $_client = '';
    private $_payload = [];

    public function __construct($module, $sandbox = false)
    {
        $this->_sandbox = $sandbox;
        $this->_module = $module;
        $this->_client = new Client(['base_uri' => $this->_getBaseURI()]);
    }

    protected function setPaymentAPICredentials($sellerId, $privateKey)
    {
        $this->_sellerId = $sellerId;
        $this->_privateKey = $privateKey;
    }

    protected function setAdminAPICredentials($userName, $password)
    {
        $this->_userName = $userName;
        $this->_password = $password;
    }

    protected function send($method, $requestType, $data)
    {
        try {
            $this->_userData = $data;


            $response = null;
            $this->_setupAPIPayload();
            switch ($requestType) {
                case "GET":
                    break;
                case "POST":
                    $response = $this->_client->post($method, $this->_payload);
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
            //$responseString = $responseString['detail'];

            return ['status' => 'ERROR', 'message' => $responseString];
        } catch (ServerException $ex) {
            $response = $ex->getResponse();
            $responseString = json_decode($response->getBody()->getContents(), true);
            //$responseString = $responseString['detail'];

            return ['status' => 'ERROR', 'message' => $responseString];
        }
    }

    private function _setupAPIPayload()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'User-Agent'   => 'PHP-2CHECKOUT/1.0',
        ];
        if ($this->_module == "PAYMENT") {
            $this->_userData['privateKey'] = $this->_privateKey;
            $this->_userData['sellerId'] = $this->_sellerId;
            $this->_payload = ['json' => json_encode($this->_userData), 'headers' => $headers];
        } else {
            $this->_payload = [
                'auth'    => [$this->_userName, $this->_password],
                'json'    => $this->_userData,
                'headers' => $headers
            ];
        }

        echo print_r($this->_payload, true);
    }

    private function _getBaseURI()
    {
        if ($this->_module == "PAYMENT") {
            return $this->_getCheckoutAPIUrl();
        } else {
            return $this->_getAdminAPIUrl();
        }
    }

    private function _getAdminAPIUrl()
    {
        if ($this->_sandbox) {
            return "";
        } else {
            return "";
        }
    }

    private function _getCheckoutAPIUrl()
    {
        if ($this->_sandbox) {
            return 'https://sandbox.2checkout.com/checkout/api/1/' . $this->_sellerId . '/rs/authService';
        } else {
            return 'https://www.2checkout.com/checkout/api/1/' . $this->_sellerId . '/rs/authService';
        }
    }
}