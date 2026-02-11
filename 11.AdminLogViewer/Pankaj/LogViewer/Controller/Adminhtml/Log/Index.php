<?php
/**
 * Copyright © Pankaj Sharma. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Pankaj\LogViewer\Controller\Adminhtml\Log;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;

/**
 * Class Index
 * Controller for displaying the Log Viewer Grid
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Load the Log Viewer Grid page
     *
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Pankaj_LogViewer::log_list');
        $resultPage->getConfig()->getTitle()->prepend(__('Log Files Management'));
        
        return $resultPage;
    }
}
