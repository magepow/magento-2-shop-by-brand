<?php

namespace Magiccart\Shopbrand\Controller\Brand;

use Magento\Framework\App\Action\Action;

class ListBrand extends Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->_pageFactory->create();
        return $result;
    }
}