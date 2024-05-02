<?php

namespace Ages\Integration\Block\System\Config;

class Widget extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var string
     */
    protected $_template = 'Ages_Integration::system/config/widget.phtml';

    /**
     * @var \Ages\Integration\Helper\Data $helper
     */
    private \Ages\Integration\Helper\Data $helper;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Ages\Integration\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Ages\Integration\Helper\Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Remove scope label
     *
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element): string
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     *
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element): string
    {
        return $this->_toHtml();
    }

    /**
     * Generate install widget button html
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getInstallWidgetButtonHtml(): string
    {
        $button = $this->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Button::class
        )->setData(
            [
                'id' => 'install_widget_button',
                'label' => __('Install Widget'),
                'disabled' => $this->getWidgetEnabled(),
            ]
        );

        return $button->toHtml();
    }

    /**
     * Generate uninstall widget button html
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getUninstallWidgetButtonHtml(): string
    {
        $button = $this->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Button::class
        )->setData(
            [
                'id' => 'uninstall_widget_button',
                'label' => __('Uninstall Widget'),
                'disabled' => ! $this->getWidgetEnabled(),
            ]
        );

        return $button->toHtml();
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
    public function getWidgetEnabled(): bool
    {
        return $this->helper->isWidgetEnabled();
    }
}
