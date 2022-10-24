<?php

namespace Webidea24\DisableFrontendDocuments\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigService
{

    private ScopeConfigInterface $config;

    public function __construct(ScopeConfigInterface $config)
    {
        $this->config = $config;
    }

    public function isKeyEnabled(string $key): bool
    {
        return !$this->config->isSetFlag(sprintf('wi24_disable_frontend_docs/%s/disabled', $key), ScopeInterface::SCOPE_WEBSITE);
    }
}
