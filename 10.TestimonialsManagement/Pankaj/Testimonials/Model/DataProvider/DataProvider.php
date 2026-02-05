<?php
namespace Pankaj\Testimonials\Model\DataProvider;

use Pankaj\Testimonials\Model\ResourceModel\Testimonials\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * DataProvider is used to edit the data
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var $loadedData
     */
    protected $loadedData;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManagerInterface;

    /**
     * Constructor
     *
     * @param string $name
     * @param mixed $primaryFieldName
     * @param mixed $requestFieldName
     * @param CollectionFactory $JobCollectionFactory
     * @param StoreManagerInterface $storeManagerInterface
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $JobCollectionFactory,
        StoreManagerInterface $storeManagerInterface,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $JobCollectionFactory->create();
        $this->storeManagerInterface = $storeManagerInterface;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get Data
     *
     * @return void
     */
    public function getData()
    {
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getTestimonialId()] = $model->getData();
            if ($model->getProfilePic()) {
                $m['profile_pic'][0]['name'] = $model->getProfilePic();
                $m['profile_pic'][0]['url'] = $this->getMediaUrl().$model->getProfilePic();
                $fullData = $this->loadedData;
                $this->loadedData[$model->getTestimonialId()] =
                array_merge($fullData[$model->getTestimonialId()], $m);//phpcs:disable
            }
        }

        return $this->loadedData;
    }

    /**
     * Get media url
     *
     * @return void
     */
    public function getMediaUrl()
    {
        return $this->storeManagerInterface->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
}
