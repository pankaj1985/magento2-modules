<?php
namespace Pankaj\Testimonials\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
use Pankaj\Testimonials\Model\ResourceModel\Testimonials\CollectionFactory;
use Pankaj\Testimonials\Model\ResourceModel\Testimonials as TestimonialResource;
use Magento\Framework\Controller\Result\RedirectFactory;

/**
 * Class massstatus is used to update status of multiple testimonials
 */
class MassStatus extends Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var TestimonialResource
     */
    protected $testimonialResource;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * Constructor
     *
     * @param Action\Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param TestimonialResource $testimonialResource
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        TestimonialResource $testimonialResource,
        RedirectFactory $resultRedirectFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->testimonialResource = $testimonialResource;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    /**
     * Execute method
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $status = (int) $this->getRequest()->getParam('status');
        $collection = $this->filter->getCollection(
            $this->collectionFactory->create()
        );

        $updated = 0;

        foreach ($collection as $testimonial) {
            $testimonial->setStatus($status);
            $this->testimonialResource->save($testimonial);
            $updated++;
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 testimonial(s) have been updated.', $updated)
        );

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
