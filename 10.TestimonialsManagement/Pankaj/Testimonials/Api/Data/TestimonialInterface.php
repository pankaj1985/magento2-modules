<?php
namespace Pankaj\Testimonials\Api\Data;

/**
 * Testimonial interface for Testimonials API
 */
interface TestimonialInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    public const TESTIMONIAL_ID = 'testimonial_id';
    public const COMPANY_NAME = 'company_name';
    public const NAME = 'name';
    public const MESSAGE = 'message';
    public const POST = 'post';
    public const PROFILE_PIC = 'profile_pic';
    public const STATUS = 'status';

    /**
     * Get value
     *
     * @return int|null
     */
    public function getTestimonialId();

    /**
     * Set value
     *
     * @param int|null $value
     * @return \Pankaj\Testimonials\Api\Data\TestimonialInterface
     */
    public function setTestimonialId($value);

    /**
     * Get value
     *
     * @return string
     */
    public function getCompanyName();

    /**
     * Set value
     *
     * @param string|null $companyName
     * @return \Pankaj\Testimonials\Api\Data\TestimonialInterface
     */
    public function setCompanyName($companyName);

    /**
     * Get value
     *
     * @return string
     */
    public function getName();

    /**
     * Set value
     *
     * @param string|null $name
     * @return \Pankaj\Testimonials\Api\Data\TestimonialInterface
     */
    public function setName($name);

    /**
     * Get value
     *
     * @return string
     */
    public function getMessage();

    /**
     * Set value
     *
     * @param string|null $message
     * @return \Pankaj\Testimonials\Api\Data\TestimonialInterface
     */
    public function setMessage($message);

    /**
     * Get value
     *
     * @return string
     */
    public function getPost();

    /**
     * Set value
     *
     * @param string|null $post
     * @return \Pankaj\Testimonials\Api\Data\TestimonialInterface
     */
    public function setPost($post);

    /**
     * Get value
     *
     * @return string
     */
    public function getProfilePic();

    /**
     * Set value
     *
     * @param string|null $profilePic
     * @return \Pankaj\Testimonials\Api\Data\TestimonialInterface
     */
    public function setProfilePic($profilePic);

    /**
     * Get value
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set value
     *
     * @param string|null $status
     * @return \Pankaj\Testimonials\Api\Data\TestimonialInterface
     */
    public function setStatus($status);
}
