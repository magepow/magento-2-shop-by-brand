<?php

namespace Magiccart\Shopbrand\Controller;

class Router implements \Magento\Framework\App\RouterInterface
{
    protected $actionFactory;
    protected $_brand;
    protected $helper;
    protected $_response;

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response,
        \Magiccart\Shopbrand\Model\ShopbrandFactory $brand,
        \Magiccart\Shopbrand\Helper\Data $helper
    )
    {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->_brand = $brand;
        $this->helper = $helper;
    }

    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        if(!$this->helper->getConfigModule('general/enabled')) return;
        $identifier = trim($request->getPathInfo(), '/');
        $router     = $this->helper->getRouter();
        $urlSuffix  = $this->helper->getUrlSuffix();
        if ($length = strlen((string) $urlSuffix)) {
            if (substr($identifier, -$length) == $urlSuffix) {
                $identifier = substr($identifier, 0, strlen($identifier) - $length);
            }
        }

        $routePath = explode('/', (string) $identifier);
        $routeSize = sizeof($routePath); //den count //

        if ($identifier == $router) {
            $request->setModuleName('shopbrand')
                    ->setControllerName('brand')
                    ->setActionName('listbrand')
                    ->setPathInfo('/shopbrand/brand/listbrand');
            return $this->actionFactory->create('Magento\Framework\App\Action\Forward');

        } elseif ($routeSize >= 2 && $routePath[0] == $router) {
            $url_key = "";
            foreach($routePath as $key => $value){
                if($key == 0 ) continue;
                $url_key .= ($key == 1) ?  $value : "/".$value;
            }
            $model = $this->_brand->create();
            $brandLoad = $model->load($url_key, 'urlkey');

            if (!empty($brandLoad)) {
                $id = $brandLoad->getData('shopbrand_id');
                if($id){
                    $request->setModuleName('shopbrand')
                        ->setControllerName('brand')
                        ->setActionName('view')
                        ->setParam('id', $id)
                        ->setPathInfo('/shopbrand/brand/view');
                    return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
                }
            }
        } else {
            return;
        }
    }
}
