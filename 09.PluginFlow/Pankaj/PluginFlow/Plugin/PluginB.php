<?php
namespace Pankaj\PluginFlow\Plugin;

use Pankaj\PluginFlow\Logger\Logger;

class PluginB
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function beforeGetName($subject)
    {
        $this->logger->info('Plugin B: BEFORE');
        return null;
    }

    public function aroundGetName($subject, callable $proceed)
    {
        $this->logger->info('Plugin B: AROUND BEFORE');
        $result = $proceed();
        $this->logger->info('Plugin B: AROUND AFTER');
        return $result;
    }

    public function afterGetName($subject, $result)
    {
        $this->logger->info('Plugin B: AFTER');
        return $result;
    }
}
