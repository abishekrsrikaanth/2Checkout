<?php

namespace Abishekrsrikaanth\TwoCheckout;


use Abishekrsrikaanth\TwoCheckout\Payment\Sale;

class Client
{
    private $_sale;
    private $_admin;

    public function __construct($sellerId, $privateKey, $userName, $password, $environment = "LIVE")
    {
        $this->_sale = new Sale($sellerId, $privateKey, $environment);
    }

    public function getSaleInstance()
    {
        return $this->_sale;
    }
}