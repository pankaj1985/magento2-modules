<?php
namespace Pankaj\ShippingLogger\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Pankaj\ShippingLogger\Logger\Logger;

class LogShippingMethod implements ObserverInterface
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        try {
            $order = $observer->getEvent()->getOrder();

            // Check if order is available
            if (!$order) {
                $this->logger->warning('ShippingLogger: Order object not found or invalid.');
                return;
            }

            //Shipping address might be null for virtual orders
            $shippingAddress = $order->getShippingAddress();
            if (!$shippingAddress) {
                $this->logger->info(
                    'ShippingLogger | Order ID: ' . $order->getIncrementId() . ' | Virtual order, no shipping.'
                );
                return;
            }

            //Get the shipping method code (e.g., "flatrate_flatrate")
            $shippingMethodCode = $order->getShippingMethod() ?? 'Not Available';

            // Get the full shipping method description/title (e.g., "Flat Rate - Fixed")
            $shippingMethodTitle = $order->getShippingDescription() ?? 'Not Available';

            //Get shipping amounts
            $shippingAmount     = (float) $order->getShippingAmount();
            $baseShippingAmount = (float) $order->getBaseShippingAmount();

            //Get currency code and symbol
            $currencyCode   = $order->getOrderCurrencyCode();
            $currencySymbol = $order->getOrderCurrency() ? $order->getOrderCurrency()->getCurrencySymbol() : $currencyCode;

            $this->logger->info(
                sprintf(
                    'ShippingLogger | Order ID: %s | Method: %s (%s) | Shipping: %s %0.2f | Base Shipping: %0.2f',
                    $order->getIncrementId(),
                    $shippingMethodTitle,
                    $shippingMethodCode,
                    $currencySymbol,
                    $shippingAmount,
                    $baseShippingAmount
                )
            );
        }
        catch (\Exception $e) {
            $this->logger->error('ShippingLogger Error: ' . $e->getMessage());
        }
    }
}
