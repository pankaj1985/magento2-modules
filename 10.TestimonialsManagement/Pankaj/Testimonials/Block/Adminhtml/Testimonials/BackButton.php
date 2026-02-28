<?php
/**
 * Copyright © Pankaj Sharma. All rights reserved.
 */
declare(strict_types=1);

namespace Pankaj\Testimonials\Block\Adminhtml\Testimonials;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class backbutton add in form
 */
class BackButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}
