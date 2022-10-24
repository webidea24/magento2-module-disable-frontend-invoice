<?php

namespace Webidea24\DisableFrontendDocuments\Plugin;

use Magento\Sales\Block\Order\Link;
use Webidea24\DisableFrontendDocuments\Helper\ConfigService;

class PreventLinkOutput
{

    private ConfigService $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @param Link $subject
     * @param callable $proceed
     * @return string
     */
    public function aroundToHtml(Link $subject, callable $proceed): string
    {
        if ($this->configService->isKeyEnabled(strtolower($subject->getData('key')))) {
            return $proceed();
        }

        return '';
    }
}
