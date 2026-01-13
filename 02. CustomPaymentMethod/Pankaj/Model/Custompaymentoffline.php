<?php
namespace Pankaj\CustomPayment\Model;

class Custompaymentoffline extends \Magento\Payment\Model\Method\AbstractMethod
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = 'custom_paymentmethod_offline';

    /**
     * Availability of offline payment method
     *
     * @var bool
     */
    protected $_isOffline = true;
}