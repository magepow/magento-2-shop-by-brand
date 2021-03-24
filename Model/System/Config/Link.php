<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-11 23:15:05
 * @@Modify Date: 2016-03-24 23:44:42
 * @@Function:
 */

namespace Magiccart\Shopbrand\Model\System\Config;

class Link implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return array(
			array('value' => 0,				'label' => __('Shop By Brand Url')),
			array('value' => 1,				'label' => __('Quick Search Results')),
			array('value' => 2,				'label' => __('Advanced Search Results')),
			array('value' => 3,				'label' => __('Custom Extra Link')),
		);
	}
}

