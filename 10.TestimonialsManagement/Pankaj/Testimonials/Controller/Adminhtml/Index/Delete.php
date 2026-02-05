<?php
namespace Pankaj\Testimonials\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Pankaj\Testimonials\Model\Testimonials;

/**
 * Class delete is used to delete testimonials
 */
class Delete extends Action
{
    /**
     * @var Testimonials
     */
    protected $testimonials;

    /**
     * Constructor
     *
     * @param Action\Context $context
     * @param Testimonials $testimonials
     */
    public function __construct(
        Action\Context $context,
        Testimonials $testimonials
    ) {
        parent::__construct($context);
        $this->testimonials = $testimonials;
    }

    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Pankaj_Testimonials::delete');
    }

    /**
     * Execute method
     *
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('testimonial_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->testimonials;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('The record has been successfully deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['testimonial_id' => $id]);
            }
        }
        $this->messageManager->addError(__('Record does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}
