<?php

/**
 * @Author: Alex Dong
 * @Date:   2021-05-17 14:55:26
 * @Last Modified by:   Alex Dong
 * @Last Modified time: 2021-05-17 14:57:30
 */

namespace Magiccart\Shopbrand\Block\Widget;

class Shopbrand extends Brand
{

    protected $_types;
    protected $_tabs = array();
    // protected $_activated = 0;
    protected $_productCfg = array();

    public function getTabActivated()
    {
        if($this->hasData('activated')) return $this->getData('activated');
        $activated = $this->getBrands()->getFirstItem();
        // $shopbrandId = $activated->getShopbrandId();
        $optionId = $activated->getData('option_id');
        if(!$optionId) return 0;
        $this->setData('activated', $optionId);
        return $optionId;
    }



    public function getAjaxCfg()
    {
        if(!$this->getProductCfg('ajax')) return 0;
        $options = array('limit', 'speed', 'timer', 'cart', 'compare', 'wishlist', 'review'); //'widthImages', 'heightImages'
        $ajax = array();
        foreach ($options as $option) {
            $ajax[$option] = $this->getProductCfg($option);
        }
        return json_encode($ajax);
    }

    public function getProductCfg($cfg='')
    {
        if(!$this->_productCfg){
            $data = $this->_helper->getConfigModule('product');
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

            $this->_productCfg = $data;

        }
        if(!$cfg) return $this->_productCfg;
        else if(isset($this->_productCfg[$cfg])) return $this->_productCfg[$cfg];
    }

    public function getFrontendProductCfg()
    { 
        if($this->getProductCfg('slide')) return $this->getSlideOptions();

        $this->_productCfg['responsive'] = json_encode($this->getGridOptions());
        return array('padding', 'responsive');

    }

    public function getContent($template)
    {
        $content = '';
        $tabs = ($this->getProductCfg('ajax')) ? $tabs = array($this->getTabActivated() => 'Activated') : $this->getBrands();
        foreach ($tabs as $type => $name) {
            $content .= $this->getLayout()->createBlock(
                'Magiccart\Shopbrand\Block\Product\GridProduct',
                "Shopbrand.Product",
                [
                    'data' => [
                        'positioned' => 'positions:list-secondary'
                    ]
                ]
            )->setActivated($type) //or ->setData('activated', $this->getTabActivated())
            ->setCfg($this->getProductCfg())
            ->setTemplate($template)
            ->toHtml();
        }
        return $content;
    }

}
