<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-11 23:15:05
 * @@Modify Date: 2021-05-30 18:10:08
 * @@Function:
 */

namespace Magiccart\Shopbrand\Model\System\Config;

class Row implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            '0'=>   __('1 row(s) without warp /slider'),
            '1'=>   __('1 row(s) /slider'),
            '2'=>   __('2 row(s) /slider'),
            '3'=>   __('3 row(s) /slider'),
            '4'=>   __('4 row(s) /slider'),
            '5'=>   __('5 row(s) /slider'),
        ];
    }
}
