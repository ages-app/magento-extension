<?php

namespace Ages\Integration\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const string XML_PATH_COMPANY_HASH = 'ages/integration/company_hash';

    const string XML_PATH_TEST_MODE = 'ages/integration/test_mode';

    const string XML_PATH_WIDGET_ENABLED = 'ages/integration/widget/enabled';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Construct
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Return company hash ID config
     *
     * @return string|null
     */
    public  function getCompanyHash(): ?string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_COMPANY_HASH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return test mode config
     *
     * @return bool
     */
    public function isTestMode(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_TEST_MODE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return widget enabled config
     *
     * @return bool
     */
    public function isWidgetEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_WIDGET_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
