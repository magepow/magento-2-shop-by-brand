<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-07-20 10:40:51
 * @@Modify Date: 2017-07-20 10:50:03
 * @@Function:
 */

namespace Magiccart\Shopbrand\Block\Product;

class View extends \Magento\Framework\View\Element\Template
{

    public $_helper;

    protected $_brand;

    /**
     * @var \Magiccart\Shopbrand\Model\ResourceModel\Shopbrand\CollectionFactory
     */

    protected $_brandCollectionFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magiccart\Shopbrand\Model\ResourceModel\Shopbrand\CollectionFactory $brandCollectionFactory,
        \Magiccart\Shopbrand\Helper\Data $helper,
        array $data = []
        ) 
    {
        $this->_coreRegistry = $registry;
        $this->_brandCollectionFactory = $brandCollectionFactory;
        $this->_helper = $helper;

        parent::__construct($context, $data); 
    }

    /**
     * Retrieve current product model
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {   
        return $this->_coreRegistry->registry('current_product');
    }

    public function getBrand()
    {
        if($this->_brand) return $this->_brand;

        $brandCode = $this->_helper->getConfigModule('general/attributeCode');
        if(!$brandCode) return;
        $_product = $this->getProduct();
        $_brandId = $_product->getData($brandCode);
        if(!$_brandId) return;
        $labelAtribute = $_product->getAttributeText($brandCode);

        $storeId = $this->_storeManager->getStore()->getStoreId();
        $brand   = $this->_brandCollectionFactory->create()
                    ->addFieldToFilter('stores',array( array('finset' => 0), array('finset' => $storeId)))
                    ->addFieldToFilter('option_id', $_brandId)
                    ->addFieldToFilter('status', 1)
                    ->setPageSize(1);
        $this->_brand = $brand->getFirstItem();
        if($this->_brand->getId()){
            $this->_brand->setData('label', $labelAtribute);
            return $this->_brand;
        }
    }

    public function getUrlBrand($brand)
    {
        return $this->_helper->getLinkBrand($brand);
    }

    public function getImage($brand)
    {
        $resizedURL = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $brand->getImage();
        return $resizedURL;
    }

}
