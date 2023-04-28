<?php
/**
 * @author Sachindra Awasthi
 * @copyright Copyright (c) 2022 Fahim (https://www.Fahimwebtechnology.com/)
 * @package Fahim_SiteMap
 */
namespace Fahim\SiteMap\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Cache\TypeListInterface as CacheTypeListInterface;

/**
 * Class AfterCategorySave
 * @package Fahim\SiteMap\Observer
 */
class AfterCategorySave implements ObserverInterface
{
    /**
     * @var \Magento\Config\Model\ResourceModel\Config
     */
    private $resourceConfig;
    /**
     * @var \Fahim\SiteMap\Helper\Data
     */
    private $dataHelper;
    /**
     * @var CacheTypeListInterface
     */
    private $cache;

    /**
     * @var \Fahim\SeoCore\Helper\Data
     */
    // protected $seoCoreHelper;

    /**
     * AfterCategorySave constructor.
     * @param \Magento\Config\Model\ResourceModel\Config $resourceConfig
     * @param CacheTypeListInterface $cache
     * @param \Fahim\SiteMap\Helper\Data $dataHelper
     * @param \Fahim\SeoCore\Helper\Data $seoCoreHelper
     */
    public function __construct(
        \Magento\Config\Model\ResourceModel\Config $resourceConfig,
        CacheTypeListInterface $cache,
        \Fahim\SiteMap\Helper\Data $dataHelper,
        // \Fahim\SeoCore\Helper\Data $seoCoreHelper
    ) {
        $this->cache = $cache;
        $this->dataHelper = $dataHelper;
        $this->resourceConfig = $resourceConfig;
        // $this->seoCoreHelper = $seoCoreHelper;
    }

    /**
     * @param EventObserver $observer
     * @return $this|void
     */
    public function execute(EventObserver $observer)
    {
        $categoryObject = $observer->getEvent()->getCategory();
        $storeId = $categoryObject->getStoreId();
        $categoryId = (string)$categoryObject->getId();
        $statusModule = $this->dataHelper->isEnable();

        $categoryDisableArray = $this->getCategoryDisableArray($storeId);

        $excludedHtmlSiteMap = $categoryObject->getExcludedHtmlSitemap();
        if ($statusModule && (int)$excludedHtmlSiteMap === 1) {
            if (!in_array($categoryId, $categoryDisableArray)) {
                $categoryDisableArray[] = $categoryId;
                $this->cache->invalidate('full_page');
            }
        }
        if ($statusModule && (int)$excludedHtmlSiteMap === 0 && in_array($categoryId, $categoryDisableArray)) {
            $arrayKey = array_search($categoryId, $categoryDisableArray);
            if ($arrayKey !== false) {
                unset($categoryDisableArray[$arrayKey]);
                $this->cache->invalidate('full_page');
            }
        }
        // $finalCategoriesDisable = $this->seoCoreHelper->implode(',', $categoryDisableArray);
        $scopeToAdd = ScopeInterface::SCOPE_STORES;
        if ((int)$storeId === 0) {
            $scopeToAdd = 'default';
        }
        $this->saveNewConfig(
            'Fahim_sitemap/category/id_category',
            $finalCategoriesDisable,
            $scopeToAdd,
            $storeId
        );
        return $this;
    }

    /**
     * @param int $storeId
     * @return array
     */
    public function getCategoryDisableArray($storeId)
    {
        $categoryDisable = $this->dataHelper->getConfigWithoutCache($storeId, 'Fahim_sitemap/category/id_category');
        if ($categoryDisable) {
            $categoryDisableArray = explode(',', $categoryDisable);
        } else {
            $categoryDisableArray = [];
        }
        return $categoryDisableArray;
    }
    /**
     * @param string $path
     * @param string $value
     * @param string $scope
     * @param string $scopeId
     * @return \Magento\Config\Model\ResourceModel\Config
     */
    protected function saveNewConfig($path, $value, $scope = 'default', $scopeId = '')
    {
        return $this->resourceConfig->saveConfig($path, $value, $scope, $scopeId);
    }
}
