<?php
/**
 * Copyright © Pankaj Sharma. All rights reserved.
 */
declare(strict_types=1);

namespace Pankaj\Testimonials\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class add used for render form
 */
class Add extends Action
{
    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Pankaj_Testimonials::add');
    }

    /**
     * Execute method
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('testimonial_id');
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $rowId ? __('Edit Testimonial') : __('Add New Testimonial');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
