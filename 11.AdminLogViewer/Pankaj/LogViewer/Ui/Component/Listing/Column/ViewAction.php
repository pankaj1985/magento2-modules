<?php
/**
 * Pankaj_LogViewer Extension
 *
 * @category  Pankaj
 * @package   Pankaj_LogViewer
 * @author    Pankaj Sharma
 */
namespace Pankaj\LogViewer\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

/**
 * Class ViewAction
 * Action column for the Log Viewer grid to provide the "View" link
 */
class ViewAction extends Column
{
    /**
     * URL route for the log view controller
     */
    const URL_PATH_VIEW = 'logviewer/log/view';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * ViewAction constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source for the column
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['file_name'])) {
                    $item[$this->getData('name')] = [
                        'view' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::URL_PATH_VIEW,
                                ['file' => $item['file_name']]
                            ),
                            'label' => __('View'),
                            'hidden' => false,
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}