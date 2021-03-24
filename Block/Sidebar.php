<?php
namespace Magiccart\Shopbrand\Block;

class Sidebar extends Brand
{
    public function getBrands()
    {
        $collection = $this->getBrandCollection();
        $collection->setOrder("'order'", 'ASC');
        // $collection->setOrder('title','ASC');
        return $collection;
    }

}