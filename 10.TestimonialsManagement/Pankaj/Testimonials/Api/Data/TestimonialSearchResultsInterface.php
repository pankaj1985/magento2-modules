<?php
namespace Pankaj\Testimonials\Api\Data;

interface TestimonialSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Testimonial list.
     *
     * @return \Pankaj\Testimonials\Api\Data\TestimonialInterface[]
     */
    public function getItems();

    /**
     * Set Testimonial list.
     *
     * @param \Pankaj\Testimonials\Api\Data\TestimonialInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
