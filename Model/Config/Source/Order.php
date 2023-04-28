<?php
/**
 * @author Sachindra Awasthi
 * @copyright Copyright (c) 2022 Fahim (https://www.Fahimwebtechnology.com/)
 * @package Fahim_SiteMap
 */
namespace Fahim\SiteMap\Model\Config\Source;

/**
 * Class Order
 * @package Fahim\SiteMap\Model\Config\Source
 */
class Order implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
 
        return [
            ['value' => 'asc', 'label' => __('ASC')],
            ['value' => 'desc', 'label' => __('DESC')],
        ];
    }
}
