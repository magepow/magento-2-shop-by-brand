<?php

namespace Magiccart\Shopbrand\Block;

use Magento\Framework\App\Filesystem\DirectoryList;

class ListBrand extends Brand implements \Magento\Framework\DataObject\IdentityInterface
{
    const DEFAULT_CACHE_TAG = 'MAGICCART_BRAND_LIST';

    protected function _construct()
    {
        $data = $this->_helper->getConfigModule('list_page_settings');
        //$dataConvert = array('infinite', 'vertical', 'autoplay', 'centerMode');
        if($data['slide']){
            $data['vertical-Swiping'] = $data['vertical'];
            $breakpoints = $this->getResponsiveBreakpoints();
            $responsive = '[';
            $num = count($breakpoints);
            foreach ($breakpoints as $size => $opt) {
                $item = (int) $data[$opt];
                $responsive .= '{"breakpoint": '.$size.', "settings": {"slidesToShow": '.$item.'}}';
                $num--;
                if($num) $responsive .= ', ';
            }
            $responsive .= ']';
            $data['slides-To-Show'] = $data['visible'];
            $data['autoplay-Speed'] = $data['autoplay_speed'];
            $data['swipe-To-Slide'] = 'true';
            $data['responsive'] = $responsive;
        }

        // $data['selector'] = 'alo-slider'.md5(rand());
        $this->addData($data);

        parent::_construct();

    }

    protected function getCacheLifetime()
    {
        return parent::getCacheLifetime() ?: 86400;
    }

    public function getCacheKeyInfo()
    {
        $keyInfo     =  parent::getCacheKeyInfo();
        $id = $this->getRequest()->getParam('keyword');
        $key = $this->_storeManager->getStore()->getStoreId();
        if($id)  $key = $key .'-'. $id;
        $keyInfo[]   =  $key;
        return $keyInfo;
    }

    /**
     * @return array
     */
    public function getIdentities()
    {
        $keyword = $this->getRequest()->getParam('keyword');
        $key = $this->_storeManager->getStore()->getStoreId();
        if($keyword)  $key = $key . '-'. $keyword;
        return [self::DEFAULT_CACHE_TAG, self::DEFAULT_CACHE_TAG . '_' . $key];
    }

    protected function _prepareLayout()
    {
        if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbs->addCrumb('home', [
                'label' => __('Home'),
                'title' => __('Go to Home Page'),
                'link'  => $this->_storeManager->getStore()->getBaseUrl()
            ])->addCrumb('brand', $this->getBreadcrumbsData());
        }

        $title = $this->_helper->getConfigModule('general/title');
        if ($brandId = $this->getRequest()->getParam('id')) {
            $brand = $this->_shopbrandFactory->create()->load($brandId);
            $title = $brand->getData('title');
            $breadcrumbs->addCrumb($title, [
                'label' => $title,
                'title' => $title
            ]);
        }
        if(!$title) $title = __('Brand');
        $this->pageConfig->getTitle()->set(__($title));
        return parent::_prepareLayout();
    }

    /**
     * @return array
     */
    protected function getBreadcrumbsData()
    {
        $data = [
            'label' => __('Brand'),
            'title' => __('Brand')
        ];
        $data['link'] =  $this->_helper->getBrandUrl();

        return $data;
    }

    public function getBrands()
    {
        $keyword = $this->getRequest()->getParam('keyword');
        $collection = $this->getBrandCollection();
        if($keyword){
            $collection->addFieldToFilter('title',['like'=>$keyword.'%']);
            $collection->setOrder('title','ASC');
        }
        return $collection;
    }

    public function getBrand()
    {
        $brandId = $this->getRequest()->getParam('id');
        if(!$brandId) return;
        return $this->_shopbrandFactory->create()->load($brandId);
    }

    /**
     * @return number
     */    
    public function getProductCount(\Magiccart\Shopbrand\Model\Shopbrand $brand)
    {
        $collection = $brand->getProductCollection();
        return $collection->count();
    }
}
