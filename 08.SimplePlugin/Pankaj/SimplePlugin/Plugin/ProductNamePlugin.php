<?php
namespace Pankaj\SimplePlugin\Plugin;

use Pankaj\SimplePlugin\Logger\Logger;

class ProductNamePlugin
{
    /** @var Logger */
    protected $logger;

    /**
     * Constructor
     *
     * @param Logger $logger
     */
    public function __construct(
        Logger $logger
    ) {
        $this->logger = $logger;
    }


    /**
     * Before plugin methods for getName
     */
    public function beforeGetName($subject)
    {
        // Executed first
        $this->logger->info('SimplePlugin: BEFORE getName');
        return null;
    }

    /**
     * Around plugin method for getName
     */
    public function aroundGetName($subject, callable $proceed)
    {
        $this->logger->info('SimplePlugin: AROUND before proceed');
        // Before original method
        $name = $proceed();
        // After original method
        $this->logger->info('SimplePlugin: AROUND after proceed');
        return $name;
    }

    /**
     * After plugin method for getName
     */
    public function afterGetName($subject, $result)
    {
        // Executed last
        $this->logger->info('SimplePlugin: AFTER getName');
        return $result;
    }
}
