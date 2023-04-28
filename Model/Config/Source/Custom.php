<?php
/**
 * @author Sachindra Awasthi
 * @copyright Copyright (c) 2022 Fahim (https://www.Fahimwebtechnology.com/)
 * @package Fahim_SiteMap
 */
namespace Fahim\SiteMap\Model\Config\Source;

/**
 * Class Custom
 * @package Fahim\SiteMap\Model\Config\Source
 */
class Custom implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
 
        return [
            ['value' => 'name', 'label' => __('Name')],
            ['value' => 'date', 'label' => __('Date')],
            ['value' => 'price', 'label' => __('Price')],
        ];
    }
}
