<?php
/**
 * @Author: nguyen
 * @Date:   2020-02-12 14:01:01
 * @Last Modified by: Alex Dong
 * @Last Modified time: 2021-03-24 14:29:26
 */

namespace Magiccart\Shopbrand\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var array
     */
    protected $configModule;

    /**
     * @var string
     */     
    protected $_urlMedia;

    /**
     * @var 
     */
    protected $_attribute;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    public $_storeManager;

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Repository
     */
    protected $_productAttributeRepository;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Catalog\Model\Product\Attribute\Repository $productAttributeRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        parent::__construct($context);
        $this->moduleManager = $moduleManager;
        $module = strtolower(str_replace('Magiccart_', '', $this->_getModuleName()));
        $this->configModule = $this->getConfig($module);
        $this->_storeManager = $storeManager;
        $this->_productAttributeRepository = $productAttributeRepository;

    }

    public function getConfig($cfg='')
    {
        if($cfg) return $this->scopeConfig->getValue( $cfg, \Magento\Store\Model\ScopeInterface::SCOPE_STORE );
        return $this->scopeConfig;
    }

    public function getConfigModule($cfg='', $value=null)
    {
        $values = $this->configModule;
        if( !$cfg ) return $values;
        $config  = explode('/', (string) $cfg);
        $end     = count($config) - 1;
        foreach ($config as $key => $vl) {
            if( isset($values[$vl]) ){
                if( $key == $end ) {
                    $value = $values[$vl];
                }else {
                    $values = $values[$vl];
                }
            } 

        }
        return $value;
    }

    public function isEnabledModule($moduleName)
    {
        return $this->moduleManager->isEnabled($moduleName);
    }

    public function getAttributeCode()
    {
        return $this->getConfigModule('general/attributeCode');
    }

    public function getRouter()
    {
        $router = $this->getConfigModule('general/router');
        return $router ? $router : 'shopbrand';
    }

    public function getUrlSuffix()
    {
        return $this->getConfigModule('general/url_suffix');

    }

    public function getRoutes()
    {
        return $this->getRouter() . $this->getUrlSuffix();
    }

    public function getUrlRouter()
    {
        return $this->_storeManager->getStore()->getBaseUrl() . $this->getRouter();
    }

    public function getUrlKey($key='', $suffix=true)
    {
        $key = trim($key, '/');
        if($key) $key =  '/' . $key;
        if($suffix) $key  = $key . $this->getUrlSuffix();
        return $this->getRouter() . $key;
    }

    public function getBrandUrl($key='', $suffix=true)
    {
        return $this->_storeManager->getStore()->getBaseUrl() . $this->getUrlKey($key, $suffix);
    }

    public function getLinkBrand($brand)
    {
        $typeLink = $this->getConfigModule('general/link');
        $baseUrl  = $this->_storeManager->getStore()->getBaseUrl();
        $attributeCode = $this->getConfigModule('general/attributeCode');
        $link = '#';
        if(!$typeLink){
            $key  = $brand->getUrlkey();
            $link = $key ? $baseUrl . $this->getUrlKey($key) : '#';
        } elseif($typeLink == '2' && $brand->getOptionId()){
            $link = $baseUrl . 'catalogsearch/advanced/result/?' . $attributeCode . urlencode('[]') . '=' . $brand->getOptionId();
        } elseif($typeLink == '1') {
            $attr = $this->getAttribute();
            if($attr->usesSource()){
                $option  = $attr->getSource()->getOptionText($brand->getOptionId());
                $link = $baseUrl . 'catalogsearch/result/?q=' .$option; 
            }
        } else {
            $link = $brand->getUrlkey();
        }

        return $link;
    }

    public function getMediaUrl($image="")
    {
        if(!$this->_urlMedia) $this->_urlMedia = $this->_storeManager->getStore()->getBaseUrl( \Magento\Framework\UrlInterface::URL_TYPE_MEDIA );
        return $this->_urlMedia . $image;
    }

    public function getAttribute()
    {
        if (!$this->_attribute) {
            $attributeCode = $this->getConfigModule('general/attributeCode');;
            $this->_attribute = $this->_productAttributeRepository->get($attributeCode); // ->getOptions();
        }
    
        return $this->_attribute;         
    }

}