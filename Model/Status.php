<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-11 23:15:05
 * @@Modify Date: 2016-03-23 16:10:15
 * @@Function:
 */

namespace Magiccart\Shopbrand\Model;

class Status
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * get available statuses.
     *
     * @return []
     */
    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_ENABLED => __('Enabled')
            , self::STATUS_DISABLED => __('Disabled'),
        ];
    }

    public static function getOptionArray()
    {
        return self::getAvailableStatuses();
    }
}
