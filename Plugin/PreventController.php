<?php

namespace Webidea24\DisableFrontendDocuments\Plugin;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Webidea24\DisableFrontendDocuments\Helper\ConfigService;

class PreventController
{

    private ConfigService $configService;
    private array $controllerList;
    private RedirectFactory $redirectFactory;

    public function __construct(RedirectFactory $redirectFactory, ConfigService $configService, array $controllerList)
    {
        $this->configService = $configService;
        $this->controllerList = $controllerList;
        $this->redirectFactory = $redirectFactory;
    }

    public function aroundDispatch(ActionInterface $subject, callable $proceed, RequestInterface $request)
    {
        foreach ($this->controllerList as $controllerClass => $key) {
            if ($subject instanceof $controllerClass && !$this->configService->isKeyEnabled($key)) {
                return $this->redirectFactory->create()->setPath('sales/order/view', [
                    'order_id' => $subject->getRequest()->getParam('order_id')
                ]);
            }
        }

        return $proceed($request);
    }
}
