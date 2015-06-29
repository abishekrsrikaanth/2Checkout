<?php namespace Abishekrsrikaanth\TwoCheckout\Payment;

use Abishekrsrikaanth\TwoCheckout\Core\Request;

class Sale extends Request
{
    private $_paymentObj;

    public function __construct($sellerId, $privateKey, $sandbox = false)
    {
        parent::__construct("PAYMENT", $sandbox);
        $this->setPaymentAPICredentials($sellerId, $privateKey);
        $this->_paymentObj = [];
    }

    public function create($orderId, $token, $currency, $total, $options = [])
    {
        $payload = [
            'merchantOrderId' => $orderId,
            'token'           => $token,
            'currency'        => $currency,
            'total'           => $total
        ];

        $payload = array_merge($payload, $options);

        if (count($this->_paymentObj['billingAddr']) < 6) {
            throw new \Exception('Billing Address not specified. Please create a a call to the setBillingAddress function to set the Billing Address');
        } else {
            $payload = array_merge($payload, $this->_paymentObj);
        }

        if (count($this->_paymentObj['shippingAddr']) < 6) {
            throw new \Exception('Shipping Address not specified. Please create a a call to the setShippingAddress function to set the Shipping Address');
        } else {
            $payload = array_merge($payload, $this->_paymentObj);
        }

        return $this->send('', 'POST', $payload);
    }

    public function setBillingAddress(
        $name,
        $address1,
        $address2,
        $city,
        $state,
        $zip,
        $country,
        $email = "",
        $phoneNumber = "",
        $phoneExt = ""
    ) {
        $billingAddress = [
            'name'     => $name,
            'address1' => $address1,
            'city'     => $city,
            'state'    => $state,
            'zipCode'  => $zip,
            'country'  => $country
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
            'name'     => $name,
            'address1' => $address1,
            'city'     => $city,
            'state'    => $state,
            'zipCode'  => $zip,
            'country'  => $country
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