<?php
/**
 * Copyright © Pankaj Sharma. All rights reserved.
 */
declare(strict_types=1);

namespace Pankaj\Testimonials\Model\ResourceModel\Testimonials;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection for Testimonials Resource Model
 */
class Collection extends AbstractCollection
{
    /**
     * Construct method
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Pankaj\Testimonials\Model\Testimonials::class,
            \Pankaj\Testimonials\Model\ResourceModel\Testimonials::class
        );
    }
}
