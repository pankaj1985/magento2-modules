<?php
namespace Pankaj\Testimonials\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Pankaj\Testimonials\Api\TestimonialRepositoryInterface;
use Pankaj\Testimonials\Api\Data\TestimonialInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class save is used for save the testimonials
 */
class Save extends Action
{
    /**
     * @var TestimonialRepositoryInterface
     */
    protected $testimonialRepository;

    /**
     * @var TestimonialInterfaceFactory
     */
    protected $testimonialFactory;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Constructor
     *
     * @param Context $context
     * @param TestimonialRepositoryInterface $testimonialRepository
     * @param TestimonialInterfaceFactory $testimonialFactory
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        TestimonialRepositoryInterface $testimonialRepository,
        TestimonialInterfaceFactory $testimonialFactory,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->testimonialRepository = $testimonialRepository;
        $this->testimonialFactory = $testimonialFactory;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * Execute method to save testimonial
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                // Check if an ID exists for editing, otherwise create new
                if (isset($data['testimonial_id']) && $data['testimonial_id']) {
                    $testimonial = $this->testimonialRepository->getById($data['testimonial_id']);
                } else {
                    $testimonial = $this->testimonialFactory->create();
                }

                // Set data
                $testimonial->setCompanyName($data['company_name']);
                $testimonial->setName($data['name']);
                $testimonial->setMessage($data['message']);
                $testimonial->setPost($data['post']);
                $testimonial->setStatus($data['status']);

                // Handle profile image upload
                if (isset($data['profile_pic']) && $data['profile_pic'][0]['name']) {
                    $imagePath = $this->uploadImage($data);
                    if (isset($data['testimonial_id'])) {
                        $imagePath = $this->uploadImage($data);
                    }
                    if ($imagePath) {
                        $testimonial->setProfilePic($imagePath);
                    }
                }

                // Save testimonial
                $this->testimonialRepository->save($testimonial);

                $this->messageManager->addSuccessMessage(__('Testimonial saved successfully.'));
                $this->dataPersistor->clear('pankaj_testimonials');

                return $this->_redirect('*/*/');
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Testimonial not found.'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the testimonial.'));
            }

            // Save data in session for repopulating the form if error occurs
            $this->dataPersistor->set('pankaj_testimonials', $data);
            return $this->_redirect('*/*/edit', ['testimonial_id' => $data['testimonial_id'] ?? null]);
        }

        return $this->_redirect('*/*/');
    }

    /**
     * Upload image
     *
     * @param array $rawData
     * @return void
     */
    public function uploadImage(array $rawData)
    {
        $data = $rawData;

        if (isset($data['profile_pic'][0]['name'])) {
            $imageName = $data['profile_pic'][0]['name'];

            if (isset($data['testimonial_id'])) {
                $data['profile_pic'] = 'testimonial/'. str_replace('testimonial/', '', $imageName);
            } else {
                $data['profile_pic'] = 'testimonial/' . $imageName;
            }
        }

        return $data['profile_pic'];
    }

    /**
     * Check ACL permissions
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Pankaj_Testimonials::add');
    }
}
