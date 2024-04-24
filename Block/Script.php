<?php

namespace Ages\Integration\Block;

class Script extends \Magento\Framework\View\Element\Template
{
    const string TEST_MODE_URL = 'https://static-staging.ages.app/integrations/widget-loader.js';

    const string LIVE_MODE_URL = 'https://static.ages.app/integrations/widget-loader.js';

    /**
     * @var \Ages\Integration\Helper\Data
     */
    private \Ages\Integration\Helper\Data $helper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Ages\Integration\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Ages\Integration\Helper\Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Return company hash ID
     *
     * @return string|null
     */
    public  function getCompanyHash(): ?string
    {
        return $this->helper->getCompanyHash();
    }

    /**
     * Return widget enabled
     *
     * @return bool
     */
    public function isWidgetEnabled(): bool
    {
        return $this->helper->isWidgetEnabled();
    }

    /**
     * Return the widget loader JS file
     *
     * @return string
     */
    public function getWidgetLoaderUrl(): string
    {
        if ($this->helper->isTestMode()) {
            return self::TEST_MODE_URL;
        }
        return self::LIVE_MODE_URL;
    }
}
