<?php
/**
 * Copyright © Pankaj Sharma. All rights reserved.
 */
declare(strict_types=1);

namespace Pankaj\Testimonials\Model;

use Pankaj\Testimonials\Api\TestimonialRepositoryInterface;
use Pankaj\Testimonials\Api\Data\TestimonialInterface;
use Pankaj\Testimonials\Model\ResourceModel\Testimonials as TestimonialResource;
use Pankaj\Testimonials\Model\TestimonialsFactory;
use Pankaj\Testimonials\Model\ResourceModel\Testimonials\CollectionFactory as TestimonialCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\CouldNotDeleteException;
use Pankaj\Testimonials\Api\Data\TestimonialSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;

class TestimonialRepository implements TestimonialRepositoryInterface
{
    /**
     * @var TestimonialResource
     */
    protected $resource;

    /**
     * @var TestimonialsFactory
     */
    protected $testimonialFactory;

    /**
     * @var TestimonialCollectionFactory
     */
    protected $testimonialCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var TestimonialSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /** @var SearchCriteriaBuilder */
    protected $searchCriteriaBuilder;

    /**
     * Constructor
     *
     * @param TestimonialResource $resource
     * @param TestimonialsFactory $testimonialFactory
     * @param TestimonialCollectionFactory $testimonialCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param TestimonialSearchResultsInterfaceFactory $searchResultsFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        TestimonialResource $resource,
        TestimonialsFactory $testimonialFactory,
        TestimonialCollectionFactory $testimonialCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        TestimonialSearchResultsInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->resource = $resource;
        $this->testimonialFactory = $testimonialFactory;
        $this->testimonialCollectionFactory = $testimonialCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritdoc
     */
    public function save(
        TestimonialInterface $testimonial
    ) {
        try {
            $this->resource->save($testimonial);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the testimonial: %1',
                $exception->getMessage()
            ));
        }
        return $testimonial;
    }

    /**
     * @inheritdoc
     *
     * For retrieving testimonial list based on the search criteria
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->testimonialCollectionFactory->create();
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritdoc
     *
     * For deleting testimonial by id
     */
    public function delete(
        $id
    ) {
        try {
            $testimonialModel = $this->testimonialFactory->create()->load($id);
            $this->resource->load($testimonialModel, $id);
            $this->resource->delete($testimonialModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Testimonial: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritdoc
     *
     * For deleting testimonial by id
     */
    public function deleteById($testimonialId)
    {
        return $this->delete($testimonialId);
    }

    /**
     * For retrieving testimonial by id
     *
     * @param int $testimonialId
     * @return TestimonialInterface
     * @throws NoSuchEntityException
     */
    public function getById($testimonialId)
    {
        $testimonial = $this->testimonialFactory->create();
        $this->resource->load($testimonial, $testimonialId);
        
        if (!$testimonial->getId()) {
            throw new NoSuchEntityException(__('Testimonial with ID "%1" not found.', $testimonialId));
        }

        return $testimonial;
    }

    /**
     * @inheritdoc
     *
     * For retrieving testimonial list by status
     */
    public function getListByStatus($status)
    {
        $allowedStatuses = [0, 1];
        if (!in_array((int)$status, $allowedStatuses)) {
            $exception = new \Magento\Framework\Exception\InputException();
            $exception->addError(
                __(
                    'Invalid status "%1". Please use 1 for Enabled or 0 for Disabled.',
                    $status
                )
            );
            throw $exception;
        }

        // Build criteria: status = $status
        $this->searchCriteriaBuilder->addFilter('status', $status);
        $criteria = $this->searchCriteriaBuilder->create();
        
        // Use existing getList method
        return $this->getList($criteria);
    }
}
