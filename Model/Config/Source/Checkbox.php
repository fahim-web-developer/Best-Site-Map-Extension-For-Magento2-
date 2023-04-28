<?php
/**
 * @author Sachindra Awasthi
 * @copyright Copyright (c) 2022 Fahim (https://www.Fahimwebtechnology.com/)
 * @package Fahim_SiteMap
 */
namespace Fahim\SiteMap\Model\Config\Source;

/**
 * Class Checkbox
 * @package Fahim\SiteMap\Model\Config\Source
 */
class Checkbox extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    public $pageFactory;

    /**
     * @var \Magento\Cms\Model\Page
     */
    public $page;

    /**
     * Checkbox constructor.
     * @param \Magento\Cms\Model\Page $page
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     */
    public function __construct(
        \Magento\Cms\Model\Page $page,
        \Magento\Cms\Model\PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
        $this->page = $page;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {

        $this->getStoreId();

        $page = $this->pageFactory->create();
        foreach ($page->getCollection() as $item) {
            $cms[$item->getId()] = $item->getTitle();
        }

        $cmsArray = [];
        $count = 0;
        foreach ($cms as $id => $title) {
            $cmsArray[$count]['value'] = $id;
            $cmsArray[$count]['label'] = $title;
            $count++;
        }
        return $cmsArray;
    }
}
