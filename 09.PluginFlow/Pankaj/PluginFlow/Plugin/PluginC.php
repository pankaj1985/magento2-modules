<?php
namespace Pankaj\PluginFlow\Plugin;

use Pankaj\PluginFlow\Logger\Logger;

class PluginC
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function beforeGetName($subject)
    {
        $this->logger->info('Plugin C: BEFORE');
        return null; // no change to original method arguments
    }

    public function aroundGetName($subject, callable $proceed)
    {
        $this->logger->info('Plugin C: AROUND BEFORE');
        $result = $proceed();
        $this->logger->info('Plugin C: AROUND AFTER');
        return $result;
    }

    public function afterGetName($subject, $result)
    {
        $this->logger->info('Plugin C: AFTER');
        return $result;
    }
}
