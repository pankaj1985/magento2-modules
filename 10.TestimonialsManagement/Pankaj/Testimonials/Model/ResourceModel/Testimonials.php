<?php
namespace Pankaj\Testimonials\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Testimonials extends AbstractDb
{
    /**
     * Construct method
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('pankaj_testimonials', 'testimonial_id');
    }
}
