<?php

/**
 * @Author: nguyen
 * @Date:   2020-09-21 14:19:18
 * @Last Modified by:   nguyen
 * @Last Modified time: 2021-03-19 14:00:24
 */

namespace Magiccart\Shopbrand\Model\Design\Frontend;

class Layout implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
        	['value' => '', 'label' => __('Default layout')], 
            ['value' => '1column', 'label' => __('1 Column')], 
        	['value' => '2columns-left', 'label' => __('2 Columns with Left Sidebar')], 
        	['value' => '2columns-right', 'label' => __('2 Columns with Right Sidebar')], 
        	['value' => '3columns', 'label' => __('3 Columns')]
        ];
    }

    public function toArray()
    {
        return [
            ['value' => '', 'label' => __('Default layout')], 
        	'1column' => __('1 Column'), 
        	'2columns-left' => __('2 Columns with Left Sidebar'), 
        	'2columns-right' => __('2 Columns with Right Sidebar'), 
        	'3columns' => __('3 Columns')
        ];
    }
}