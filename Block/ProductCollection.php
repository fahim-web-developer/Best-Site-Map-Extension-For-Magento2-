<?php
/**
 * @author Sachindra Awasthi
 * @copyright Copyright (c) 2022 Fahim (https://www.Fahimwebtechnology.com/)
 * @package Fahim_SiteMap
 */
namespace Fahim\SiteMap\Block;

/**
 * Class ProductCollection
 * @package Fahim\SiteMap\Block
 */
class ProductCollection extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    public $productCollectionFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public $scopeConfig;

    /**
     * @var $helper
     */
    public $helper;

    /**
     * ItemsCollection constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Fahim\SiteMap\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Fahim\SiteMap\Helper\Data $helper,
        array $data = []
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->helper = $helper;
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return \Fahim\SiteMap\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductCollection()
    {
        $maxProducts = $this->helper->getMaxProduct();
        $maxProducts = (int)$maxProducts;
        if ($maxProducts >= 0 && $maxProducts != null) {
            if ($maxProducts > 50000) {
                $maxProducts = 50000;
            }
        } else {
            $maxProducts = 50000;
        }

        $sortProduct = $this->helper->getSortProduct();
        $orderProduct = $this->helper->getOrderProduct();

        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');

        $collection->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
        $rulerStatus = \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED;

        $collection
            ->addAttributeToFilter('status', $rulerStatus)
            ->addFieldToFilter('excluded_html_sitemap', [
                ['null' => true],
                ['eq' => ''],
                ['eq' => 'NO FIELD'],
                ['eq' => '0'],
            ]);

        $collection->addWebsiteFilter();
        $collection->addUrlRewrite();
        $collection->addAttributeToSort($sortProduct, $orderProduct);
        $collection->setPageSize($maxProducts);
        return $collection;
    }
}
