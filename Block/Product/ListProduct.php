<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-06-29 10:49:59
 * @@Function:
 */

namespace Magiccart\Shopbrand\Block\Product;

use Magento\Catalog\Api\CategoryRepositoryInterface;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{

    /**
     * Product collection model
     *
     * @var Magento\Catalog\Model\Resource\Product\Collection
     */
    protected $_productCollection;

    /**
     * Catalog Layer
     *
     * @var Magento\Catalog\Model\Layer\Resolver
     */
    protected $_catalogLayer;

    /**
     * @var \Magento\Framework\Data\Helper\PostHelper
     */
    protected $_postDataHelper;

    /**
     * @var \Magento\Framework\Url\Helper\Data
     */
    protected $urlHelper;
    
    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * Catalog product visibility
     *
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $_catalogProductVisibility;

    /**
     * Product collection factory
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;

    /**
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_objectManager;

    /**
     * @var _stockconfig
     */
    protected $_stockConfig;

     /**
     * @var \Magento\CatalogInventory\Helper\Stock
     */
    protected $_stockFilter;

    /**
     * [$_brandFactory description]
     * @var \Magiccart\Shopbrand\Model\ShopbrandFactory 
     */
    protected $_brandFactory;
    /**
     * [$_limit description]
     * @var [type]
     */
    protected $_limit; // Limit Product
    /**
     * [$_helperData description]
     * @var [type]
     */
    protected $_helperData;
    /**
     * Initialize
     *
     * @param Magento\Catalog\Block\Product\Context $context
     * @param Magento\Framework\Data\Helper\PostHelper $postDataHelper
     * @param Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository,
     * @param Magento\Catalog\Model\ResourceModel\Product\Collection $collection
     * @param Magento\Framework\Url\Helper\Data $urlHelper
     * @param Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context, 
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper, 
        \Magento\Catalog\Model\Layer\Resolver $layerResolver, 
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Eav\Model\Config $eavConfig,
        \Magiccart\Shopbrand\Model\ShopbrandFactory $brandFactory,
        \Magiccart\Shopbrand\Helper\Data $helperData,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\CatalogInventory\Helper\Stock $stockFilter,
        \Magento\CatalogInventory\Model\Configuration $stockConfig,
            array $data = []
    ) {
        $this->_catalogLayer = $layerResolver->get();
        $this->_postDataHelper = $postDataHelper;
        $this->categoryRepository = $categoryRepository;
        $this->urlHelper = $urlHelper;
        $this->_brandFactory = $brandFactory;
        $this->_helperData = $helperData;
        $this->_eavConfig = $eavConfig;
        $this->_objectManager = $objectManager;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_catalogProductVisibility = $catalogProductVisibility;
        $this->_stockFilter = $stockFilter;
        $this->_stockConfig = $stockConfig;

        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
    }

    public function getType()
    {   
        $brandId = $this->getRequest()->getParam('id', 0);
        $option_id = $this->_brandFactory->create()->load($brandId);
        return $option_id;
    }

    public function getWidgetCfg($cfg=null)
    {
        $info = $this->getRequest()->getParam('info');
        if($info){
            if(isset($info[$cfg])) return $info[$cfg];
            return $info;          
        }else {
            $info = $this->getCfg();
            if(isset($info[$cfg])) return $info[$cfg];
            return $info;
        }
    }

    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {

            $brand = $this->getType()->getData('option_id');
            $collection = $this->getBrandProducts($brand);

            if ($this->_stockConfig->isShowOutOfStock() != 1) {
                $this->_stockFilter->addInStockFilterToCollection($collection);
            }
            // $this->_eventManager->dispatch(
            //     'catalog_block_product_list_collection',
            //     ['collection' => $collection]
            // );

            $this->_productCollection = $collection;
        }

        $page = $this->getRequest()->getParam('p', 1);

        return $this->_productCollection->setCurPage($page);
    }

    public function getBrandProducts($brand)
    {   
        $attributeCode = $this->_helperData->getConfigModule('general/attributeCode');
        $this->_limit = $this->getWidgetCfg('limit');
        $collection = $this->_productCollectionFactory->create();
        $collection->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());
        $collection->addAttributeToFilter($attributeCode, $brand)
                    ->addStoreFilter()
                    ->addAttributeToSelect('*')
                    ->addMinimalPrice()
                    ->addFinalPrice()
                    ->addTaxPercents()
                    ->setPageSize($this->_limit);

        return $collection;

    }

}
