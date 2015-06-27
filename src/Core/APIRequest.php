<?php namespace Abishekrsrikaanth\TwoCheckout\Core;

use GuzzleHttp\Client;

class APIRequest
{
    private $_sandbox = false;
    private $_sellerId = '';
    private $_privateKey = '';
    private $_module = '';

    public function __construct($sellerId, $privateKey, $module, $sandbox = false)
    {
        $this->_sellerId = $sellerId;
        $this->_privateKey = $privateKey;
        $this->_sandbox = $sandbox;
        $this->_module = $module;
    }

    public function sendRequest()
    {
        $client = new Client(['base_uri' => $this->getBaseURI()]);
        $headers = [
            'Content-Type'=>'application/json'
        ];
        $client->post('', ['headers' => $headers]);
    }

    private function getBaseURI()
    {
        if ($this->_module == "PAYMENT") {
            return $this->getCheckoutAPIUrl();
        } else {
            return $this->getAdminAPIUrl();
        }
    }

    private function getAdminAPIUrl()
    {
        if ($this->_sandbox) {
            return "";
        } else {
            return "";
        }
    }

    private function getCheckoutAPIUrl()
    {
        if ($this->_sandbox) {
            return 'https://sandbox.2checkout.com/checkout/api/1/' . $this->_sellerId . '/rs/authService';
        } else {
            return 'https://www.2checkout.com/checkout/api/1/' . $this->_sellerId . '/rs/authService';
        }
    }
}