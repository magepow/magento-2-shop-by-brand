<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2016-01-07 22:10:30
 * @@Modify Date: 2016-03-24 11:58:57
 * @@Function:
 */

namespace Magiccart\Shopbrand\Model\System\Config;

class Brand implements \Magento\Framework\Option\ArrayInterface
{

    protected $_scopeConfig;
    protected $_options = array();

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Repository $_productAttributeRepository
     */
    protected $_productAttributeRepository;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\Product\Attribute\Repository $productAttributeRepository
    )
    {
        $this->_productAttributeRepository = $productAttributeRepository;
        $this->_scopeConfig= (object) $scopeConfig->getValue(
            'shopbrand',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function toOptionArray()
    {
        if(!$this->_options){
            $options = array();
            $cfg = $this->_scopeConfig->general;
            if(isset($cfg['attributeCode'])){
                $brands = $this->_productAttributeRepository->get($cfg['attributeCode'])->getOptions();
                foreach ($brands as $brand) {
                    $options[$brand->getValue()] = $brand->getLabel();
                }
            }
            $this->_options = $options;
        }
        return $this->_options;
    }

}
