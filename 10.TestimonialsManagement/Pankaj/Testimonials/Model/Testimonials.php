<?php
/**
 * Copyright © Pankaj Sharma. All rights reserved.
 */
declare(strict_types=1);

namespace Pankaj\Testimonials\Model;

use Pankaj\Testimonials\Api\Data\TestimonialInterface;
use Magento\Framework\Model\AbstractModel;
use Pankaj\Testimonials\Model\ResourceModel\Testimonials as TestimonialResource;

class Testimonials extends AbstractModel implements TestimonialInterface
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(TestimonialResource::class);
    }

    /**
     * @inheritdoc
     */
    public function getTestimonialId()
    {
        return $this->getData(self::TESTIMONIAL_ID);
    }

    /**
     * @inheritdoc
     */
    public function setTestimonialId($value)
    {
        return $this->setData(self::TESTIMONIAL_ID, $value);
    }

    /**
     * @inheritdoc
     */
    public function getCompanyName()
    {
        return $this->getData(self::COMPANY_NAME);
    }

    /**
     * @inheritdoc
     */
    public function setCompanyName($companyName)
    {
        return $this->setData(self::COMPANY_NAME, $companyName);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritdoc
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * @inheritdoc
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * @inheritdoc
     */
    public function getPost()
    {
        return $this->getData(self::POST);
    }

    /**
     * @inheritdoc
     */
    public function setPost($post)
    {
        return $this->setData(self::POST, $post);
    }

    /**
     * @inheritdoc
     */
    public function getProfilePic()
    {
        return $this->getData(self::PROFILE_PIC);
    }

    /**
     * @inheritdoc
     */
    public function setProfilePic($profilePic)
    {
        return $this->setData(self::PROFILE_PIC, $profilePic);
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritdoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}
