<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-11 23:15:05
 * @@Modify Date: 2017-03-21 19:19:32
 * @@Function:
 */

namespace Magiccart\Shopbrand\Model\System\Config;

class Col implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            '1'=>   __('1 item(s) /row'),
            '2'=>   __('2 item(s) /row'),
            '3'=>   __('3 item(s) /row'),
            '4'=>   __('4 item(s) /row'),
            '5'=>   __('5 item(s) /row'),
            '6'=>   __('6 item(s) /row'),
            '7'=>   __('7 item(s) /row'),
            '8'=>   __('8 item(s) /row'),
        ];
    }
}
