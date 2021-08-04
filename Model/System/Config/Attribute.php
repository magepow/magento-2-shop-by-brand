<?php

/**
 * @Author: nguyen
 * @Date:   2021-08-04 14:01:59
 * @Last Modified by:   Alex Dong
 * @Last Modified time: 2021-08-04 14:06:03
 */

namespace Magiccart\Shopbrand\Model\System\Config;

class Attribute implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory
     */
    protected $_collectionFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $collectionFactory
    )
    {
        $this->_collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        $options = array('' => __('Choose brand attribute'));
        $collection = $this->_collectionFactory->create()
                        ->addFieldToFilter('frontend_input', ['select', 'multiselect'])
                        ->addVisibleFilter();
        $collection->setOrder('frontend_label','ASC');
        foreach ($collection as $item) {
            $options[$item->getAttributeCode()] = $item->getFrontendLabel();
        }
        return $options;
    }

}
