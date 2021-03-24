<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-11 23:15:05
 * @@Modify Date: 2016-03-24 16:52:18
 * @@Function:
 */

namespace Magiccart\Shopbrand\Model;

class Shopbrand extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $_catalogProductVisibility;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;

    /**
     * @var \Magiccart\Shopbrand\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magiccart\Shopbrand\Model\ResourceModel\Shopbrand\CollectionFactory
     */

    protected $_shopbrandCollectionFactory;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magiccart\Shopbrand\Model\ResourceModel\Shopbrand\CollectionFactory $shopbrandCollectionFactory,
        \Magiccart\Shopbrand\Model\ResourceModel\Shopbrand $resource,
        \Magiccart\Shopbrand\Model\ResourceModel\Shopbrand\Collection $resourceCollection,
        \Magiccart\Shopbrand\Helper\Data $helper
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_catalogProductVisibility = $catalogProductVisibility;

        $this->_helper = $helper;
        $this->_shopbrandCollectionFactory = $shopbrandCollectionFactory;
    }
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Magiccart\Shopbrand\Model\ResourceModel\Shopbrand');
    }
    /**
     * Retrieve post related products
     * @param  int $storeId
     * @return \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    public function getRelatedProducts($storeId = null)
    {
        if (!$this->hasData('related_products')) {

            $collection = $this->_productCollectionFactory->create();

            if (!is_null($storeId)) {
                $collection->addStoreFilter($storeId);
            } elseif ($storeIds = $this->getStoreId()) {
                $collection->addStoreFilter($storeIds[0]);
            }

            $attributeCode = $this->_helper->getConfigModule('general/attributeCode');
            if($attributeCode){
                $collection->addAttributeToFilter($attributeCode,  $this->getOptionId());
            }

            $this->setData('related_products', $collection);
        }
        
        return $this->getData('related_products');
    }
    public function getProductsPosition()
    {
        if (!$this->getId()) {
            return [];
        }
        $array = $this->getData('products_position');
        if ($array === null) {
            $array = $this->getResource()->getProductsPosition($this);
            $this->setData('products_position', $array);
        }

        return $array;
    }
    public function getProductCollection()
    {   
        $collection = $this->_productCollectionFactory->create()->addAttributeToSelect('*')
                            ->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());
        $attributeCode = $this->_helper->getConfigModule('general/attributeCode');
        if($attributeCode){
            $collection->addAttributeToFilter($attributeCode,  $this->getOptionId());
        }
        return $collection;
    }

}
