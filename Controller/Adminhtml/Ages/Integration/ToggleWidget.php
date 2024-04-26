<?php

namespace Ages\Integration\Controller\Adminhtml\Ages\Integration;

class ToggleWidget extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const string ADMIN_RESOURCE = 'Ages_Integration::company_config';

    /**
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    protected \Magento\Framework\App\Config\Storage\WriterInterface $configWriter;

    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected \Magento\Framework\Controller\Result\JsonFactory $jsonFactory;

    /**
     * @var \Magento\Framework\Filter\StripTags
     */
    protected \Magento\Framework\Filter\StripTags $tagFilter;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Framework\Filter\StripTags $tagFilter
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Framework\Filter\StripTags $tagFilter
    ) {
        parent::__construct($context);
        $this->configWriter = $configWriter;
        $this->cacheTypeList = $cacheTypeList;
        $this->jsonFactory = $jsonFactory;
        $this->tagFilter = $tagFilter;
    }

    public function execute(): \Magento\Framework\Controller\Result\Json
    {
        $method = $this->getRequest()->getMethod();
        $response = $this->jsonFactory->create();
        $enabled = (bool) $this->getRequest()->getParam('enabled');
        $result = [
            'success' => false,
            'errorMessage' => '',
        ];
        if ($method === 'POST') {
            try {
                $this->configWriter->save(\Ages\Integration\Helper\Data::XML_PATH_WIDGET_ENABLED, (int) $enabled);
                $this->cleanCaches();
                $this->addSuccessMessage($enabled);
                $result['success'] = true;
                return $response->setData($result);
            } catch (\Exception $e) {
                $result['errorMessage'] = __('Failed to install chat widget, %1.', $this->tagFilter->filter($e->getMessage()));
                return $response->setHttpResponseCode(500)->setData($result);
            }
        }
        $result['errorMessage'] = __('Bad request. Only POST request is allowed.');
        return $response->setHttpResponseCode(400)->setData($result);
    }

    /**
     * Manually clear the config and full page caches
     *
     * @return void
     */
    private function cleanCaches(): void
    {
        // Config cache
        $this->cacheTypeList->cleanType(\Magento\Framework\App\Cache\Type\Config::TYPE_IDENTIFIER);
        // Full page cache
        $this->cacheTypeList->cleanType(\Magento\PageCache\Model\Cache\Type::TYPE_IDENTIFIER);

    }

    /**
     * @param bool $enabled
     * @return void
     */
    private function addSuccessMessage(bool $enabled): void
    {
        $action = $enabled ? 'enabled' : 'disabled';
        $this->messageManager->addSuccessMessage(__('Chat widget is %1.', $action));
    }
}

