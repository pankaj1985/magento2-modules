<?php
declare(strict_types=1);

namespace Pankaj\Testimonials\Api;

use Pankaj\Testimonials\Api\Data\TestimonialInterface;

interface TestimonialRepositoryInterface
{
    /**
     * Save testimonial
     *
     * @param \Pankaj\Testimonials\Api\Data\TestimonialInterface $testimonial
     * @return \Pankaj\Testimonials\Api\Data\TestimonialInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(TestimonialInterface $testimonial);

    /**
     * Retrieve Testimonial matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Pankaj\Testimonials\Api\Data\TestimonialSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Retrieve testimonial by ID
     *
     * @param int $testimonialId
     * @return \Pankaj\Testimonials\Api\Data\TestimonialInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($testimonialId);

    /**
     * Delete Testimonial
     *
     * @param \Pankaj\Testimonials\Api\Data\TestimonialInterface $testimonial
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        TestimonialInterface $testimonial
    );

    /**
     * Delete Testimonial by ID
     *
     * @param string $testimonialId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($testimonialId);

    /**
     * Get testimonials by status (Simple Route)
     *
     * @param int $status
     * @return \Pankaj\Testimonials\Api\Data\TestimonialSearchResultsInterface
     */
    public function getListByStatus($status);
}
