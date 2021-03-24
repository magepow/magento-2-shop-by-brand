<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magiccart\Shopbrand\Model\Design\Frontend;

class Responsive
{

    public static function getBreakpoints()
    {
        return array(1921=>'visible', 1920=>'widescreen', 1480=>'desktop', 1200=>'laptop', 992=>'notebook', 768=>'tablet', 576=>'landscape', 481=>'portrait', 361=>'mobile', 1=>'mobile');
    }

}
