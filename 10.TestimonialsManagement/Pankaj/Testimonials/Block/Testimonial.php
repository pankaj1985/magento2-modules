<?php
namespace Pankaj\Testimonials\Block;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Template;
use Pankaj\Testimonials\Api\TestimonialRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * For getting testimonials data
 */
class Testimonial extends Template
{
    /**
     *  @var TestimonialRepositoryInterface 
     */
    private $testimonialRepository;

    /** 
     * @var SearchCriteriaBuilder 
     */
    private $searchCriteriaBuilder;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param CollectionFactory $testimonialCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        TestimonialRepositoryInterface $testimonialRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->testimonialRepository = $testimonialRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * Get only enabled testimonials
     */
    public function getTestimonials()
    {
        $this->searchCriteriaBuilder->addFilter('status', 1);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->testimonialRepository->getList($searchCriteria)->getItems();
    }

    /**
     * Get Media URL for Testimonial Images
     *
     * @param string $imagePath
     * @return string
     */
    public function getImageUrl($imagePath)
    {
        return $this->_storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . '/' . $imagePath;
    }
}
