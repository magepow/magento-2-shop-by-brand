<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-06-23 15:25:03
 * @@Function:
 */

namespace Magiccart\Shopbrand\Controller\Index;

use Magento\Framework\Controller\ResultFactory; 

class Product extends \Magiccart\Shopbrand\Controller\Index
{
    /**
     * Default customer account page.
     */
    public function execute()
    {
    	if ($this->getRequest()->isAjax()) {
	        $this->_view->loadLayout();
	        // $this->_view->renderLayout();
	        $info = $this->getRequest()->getParam('info');
	        $type = $this->getRequest()->getParam('type');
	        $tmp = $info['timer'] ? 'product/gridtimer.phtml':'product/grid.phtml';
	        $products = $this->_view->getLayout()->createBlock(
									'Magiccart\Shopbrand\Block\Product\GridProduct',
									"Shopbrand.Product",
									[
										'data' => [
											'positioned' => 'positions:list-secondary'
										]
									]
								)->setCfg($info)
					           	->setActivated($type)
					           	->setTemplate($tmp)
					           	->toHtml();
	        $this->getResponse()->setBody( $products );
	    }else {
	        $resultRedirect = $this->_resultPageFactory->create(ResultFactory::TYPE_REDIRECT);
	        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
	        return $resultRedirect;
	    }
    }
}
