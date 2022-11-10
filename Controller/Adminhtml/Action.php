<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-06-08 14:41:14
 * @@Function:
 */

namespace Magiccart\Shopbrand\Controller\Adminhtml;

abstract class Action extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected $_jsHelper;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * A factory that knows how to create a "page" result
     * Requires an instance of controller action in order to impose page type,
     * which is by convention is determined from the controller action class.
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    protected $_shopbrandFactory;

    protected $_shopbrandCollectionFactory;

    /**
     * Model class name
     * @var string
     */
    // protected $_modelClass      = 'Magiccart\Shopbrand\Model\Shopbrand';

    /**
     * Registry object.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * File Factory.
     *
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $_fileFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magiccart\Shopbrand\Model\ShopbrandFactory $shopbrandFactory,
        \Magiccart\Shopbrand\Model\ResourceModel\Shopbrand\CollectionFactory $shopbrandCollectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Backend\Helper\Js $jsHelper
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_fileFactory = $fileFactory;
        $this->_jsHelper = $jsHelper;

        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultLayoutFactory = $resultLayoutFactory;
        $this->_resultForwardFactory = $resultForwardFactory;
		$this->_resultRedirectFactory = $context->getResultRedirectFactory();
		
        $this->_shopbrandFactory = $shopbrandFactory;
        $this->_shopbrandCollectionFactory = $shopbrandCollectionFactory;
    }

    protected function _isAllowed()
    {
        $namespace = (new \ReflectionObject($this))->getNamespaceName();
        $string = strtolower(str_replace(__NAMESPACE__ . '\\','', (string) $namespace));
        $action =  explode('\\', (string) $string);
        $action =  array_shift($action);
        return $this->_authorization->isAllowed("Magiccart_Shopbrand::shopbrand_$action");
    }
}
