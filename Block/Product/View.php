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

    protected $_brandCollectionFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    protected $_attribute;
    protected $_brand;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magiccart\Shopbrand\Model\ResourceModel\Shopbrand\CollectionFactory $brandCollectionFactory,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
        ) {
        $this->_brandCollectionFactory = $brandCollectionFactory;
        $data = $context->getScopeConfig()->getValue(
                            'shopbrand/general',
                            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                        );
        $this->addData($data);
        $this->_coreRegistry = $registry;
        $this->_resource = $resource;
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
        $brandCode = $this->getData('attributeCode');
        if(!$brandCode) return;
        $_product = $this->getProduct();
        $_brandId = $_product->getData($brandCode);
        if(!$_brandId) return;
        $_label_atribute = $_product->getAttributeText($brandCode);

        if(!$this->_brand){
            $store = $this->_storeManager->getStore()->getStoreId();
            $brand = $this->_brandCollectionFactory->create()
                        ->addFieldToFilter('stores',array( array('finset' => 0), array('finset' => $store)))
                        ->addFieldToFilter('option_id', $_brandId)
                        ->addFieldToFilter('status', 1);
            $this->_brand = $brand->getFirstItem();
            $this->_brand->setData('label', $_label_atribute);
            // $attr = $_product->getResource()->getAttribute($brandCode);
            // if ($attr->usesSource()) {
            //     $optionText = $attr->getSource()->getOptionText($_brandId);
            //     if($optionText) $this->_brand->setTitle($optionText);
            // }

        }
        return $this->_brand;

    }

    public function getUrlBrand($brand)
    {
        $typeLink = $this->getData('link');
        $baseUrl  = $this->_storeManager->getStore()->getBaseUrl();
        $attrCode = $this->getData('attributeCode');
        $link = '#';
        if(!$typeLink) $link = $brand->getUrlkey() ? $baseUrl . $brand->getUrlkey() : '#';
        elseif($typeLink == '2'){
            $link = $baseUrl . 'catalogsearch/advanced/result/?' . $attrCode . urlencode('[]') . '=' . $brand->getOptionId();
        } elseif($typeLink == '1') {
            $attr = $this->getAttribute();
            if($attr->usesSource()){
                $option  = $attr->getSource()->getOptionText($brand->getOptionId());
                $link = $baseUrl . 'catalogsearch/result/?q=' .$option; 
            }
        }
        return $link;
    }

    public function getAttribute()
    {
        if (!$this->_attribute) {
            $brandCode = $this->getData('attributeCode');
            $this->_attribute = $this->getProduct()->getResource()->getAttribute($brandCode);
        }
        return $this->_attribute;         
    }

    public function getImage($object)
    {
        $resizedURL = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $object->getImage();
        return $resizedURL;
    }


}
