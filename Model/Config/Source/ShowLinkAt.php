<?php
/**
 * @author Sachindra Awasthi
 * @copyright Copyright (c) 2022 Fahim (https://www.Fahimwebtechnology.com/)
 * @package Fahim_SiteMap
 */
namespace Fahim\SiteMap\Model\Config\Source;

/**
 * Class ShowLinkAt
 * @package Fahim\SiteMap\Model\Config\Source
 */
class ShowLinkAt implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'footer', 'label' => __('Footer')],
            ['value' => 'top', 'label' => __('Header')]
        ];
    }
}
