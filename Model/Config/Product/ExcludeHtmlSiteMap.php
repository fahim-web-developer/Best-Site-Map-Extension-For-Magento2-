<?php
/**
 * @author Sachindra Awasthi
 * @copyright Copyright (c) 2022 Fahim (https://www.Fahimwebtechnology.com/)
 * @package Fahim_SiteMap
 */
namespace Fahim\SiteMap\Model\Config\Product;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class ExcludeHtmlSiteMap
 * @package Fahim\SiteMap\Model\Config\Product
 */
class ExcludeHtmlSiteMap extends AbstractSource
{
    /**
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [];
        $this->_options[] = ['label' => 'No', 'value' => '0'];
        $this->_options[] = ['label' => 'Yes', 'value' => '1'];
        return $this->_options;
    }
}
