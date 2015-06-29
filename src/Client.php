<?php

namespace Abishekrsrikaanth\TwoCheckout;


use Abishekrsrikaanth\TwoCheckout\Payment\Sale;

class Client
{
    private $_sale;
    private $_admin;

    public function getSaleInstance($sellerId, $privateKey, $sandbox = false)
    {
        $this->_sale = new Sale($sellerId, $privateKey, $sandbox);
        return $this->_sale;
    }

    public function getAdminInstance($userName, $password, $environment = "LIVE")
    {

    }
}