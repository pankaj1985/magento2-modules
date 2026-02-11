<?php
/**
 * Copyright © Pankaj Sharma. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Pankaj\LogViewer\Block\Adminhtml\Log;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;

/**
 * Class View
 * Block class to provide log data to the view template
 */
class View extends Template
{
    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * View constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Get log content from registry
     *
     * @return string|null
     */
    public function getLogContent()
    {
        return $this->_coreRegistry->registry('log_content');
    }

    /**
     * Get log file name from registry
     *
     * @return string|null
     */
    public function getLogFileName()
    {
        return $this->_coreRegistry->registry('log_file_name');
    }

    /**
     * Get back URL for the grid page
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/index');
    }
}
