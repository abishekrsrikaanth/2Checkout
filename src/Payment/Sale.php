<?php namespace Abishekrsrikaanth\TwoCheckout\Payment;


use Abishekrsrikaanth\TwoCheckout\Core\APIRequest;

class Sale extends APIRequest
{
    private $_paymentObj;

    public function __construct($sellerId, $privateKey, $sandbox = false)
    {
        parent::__construct($sellerId, $privateKey, "PAYMENT", $sandbox);
        $this->_paymentObj = [];
    }

    public function create($orderId, $token, $currency, $total, $options = [])
    {

    }

    public function setBillingAddress($name, $address1, $address2, $city, $state, $zip, $country, $email = "", $phoneNumber = "", $phoneExt = "")
    {
        $billingAddress = [
            'name' => $name,
            'address1' => $address1,
            'city' => $city,
            'state' => $state,
            'zipCode' => $zip,
            'country' => $country
        ];

        if ($address2 != "") {
            $billingAddress['address2'] = $address2;
        }

        if ($email != "") {
            $billingAddress['email'] = $email;
        }

        if ($phoneNumber != "") {
            $billingAddress['phoneNumber'] = $phoneNumber;
        }

        if ($phoneExt != "") {
            $billingAddress['phoneExt'] = $phoneExt;
        }

        $this->_paymentObj['billingAddr'] = $billingAddress;
    }

    public function setShippingAddress($name, $address1, $address2, $city, $state, $zip, $country)
    {
        $shippingAddress = [
            'name' => $name,
            'address1' => $address1,
            'city' => $city,
            'state' => $state,
            'zipCode' => $zip,
            'country' => $country
        ];

        if ($address2 != "") {
            $billingAddress['address2'] = $address2;
        }

        $this->_paymentObj['shippingAddr'] = $shippingAddress;
    }

    public function addLineItem()
    {

    }
}