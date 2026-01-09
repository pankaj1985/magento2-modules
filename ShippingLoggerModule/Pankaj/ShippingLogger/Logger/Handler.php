<?php
namespace Pankaj\ShippingLogger\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Handler extends Base
{
    protected $fileName = '/var/log/shipping.log';
    protected $loggerType = Logger::INFO;
}
