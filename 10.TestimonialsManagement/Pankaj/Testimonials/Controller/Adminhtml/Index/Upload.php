<?php
/**
 * Copyright © Pankaj Sharma. All rights reserved.
 */
declare(strict_types=1);

namespace Pankaj\Testimonials\Controller\Adminhtml\Index;

use Exception;
use Pankaj\Testimonials\Model\ImageUploader;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class upload is used for the image upload
 */
class Upload extends Action implements HttpPostActionInterface
{
    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * Constructor
     *
     * @param Context $context
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Execute method
     *
     * @return void
     */
    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'profile_pic');

        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
