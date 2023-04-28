<?php
/**
 * @author Sachindra Awasthi
 * @copyright Copyright (c) 2022 Fahim (https://www.Fahimwebtechnology.com/)
 * @package Fahim_SiteMap
 */
namespace Fahim\SiteMap\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class AddSitemap
 * @package Fahim\SiteMap\Observer
 */
class AddSitemap implements ObserverInterface
{
    /**
     * @var \Fahim\SiteMap\Block\ItemsCollection
     */
    private $siteMapBlock;

    /**
     * @var \Fahim\GeoIPAutoSwitchStore\Helper\Data
     */
    private $dataHelper;

    /**
     * AddSiteMap constructor.
     * @param \Fahim\SiteMap\Helper\Data $dataHelper
     * @param \Fahim\SiteMap\Block\ItemsCollection $siteMapBlock
     */
    public function __construct(
        \Fahim\SiteMap\Helper\Data $dataHelper,
        \Fahim\SiteMap\Block\ItemsCollection $siteMapBlock
    ) {
        $this->siteMapBlock = $siteMapBlock;
        $this->dataHelper = $dataHelper;
    }

    /**
     * Add New Layout handle
     *
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $layout = $observer->getData('layout');
        $helper = $this->dataHelper;
        $orderTemplates = $helper->orderTemplates();

        $block = $this->siteMapBlock;

        if ($orderTemplates == '' || $orderTemplates == null) {
            $orderTemplates = $block::PRODUCT_LIST_NUMBER . ',' . $block::STORE_VIEW_LIST_NUMBER . ',' . $block::ADDITIONAL_LIST_NUMBER . ',' . $block::CATE_AND_CMS_NUMBER;
        }

        $orderTemplates = "," . $orderTemplates . ",";
        $orderTemplates = explode(',', $orderTemplates);

        $fullActionName = $observer->getData('full_action_name');

        if ($fullActionName != 'custom_route_index_index') {
            return $this;
        }

        foreach ($orderTemplates as $key) {
            if ($key == $block::PRODUCT_LIST_NUMBER) {
                $layout->getUpdate()->addHandle('sitemap_product_list');
            }

            if ($key == $block::STORE_VIEW_LIST_NUMBER) {
                $layout->getUpdate()->addHandle('sitemap_store_list');
            }

            if ($key == $block::ADDITIONAL_LIST_NUMBER) {
                $layout->getUpdate()->addHandle('sitemap_additional_list');
            }

            if ($key == $block::CATE_AND_CMS_NUMBER) {
                $layout->getUpdate()->addHandle('sitemap_category_cms_list');
            }
        }

        return $this;
    }
}
