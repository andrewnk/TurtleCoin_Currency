<?php

namespace TurtleCoin\Currency\Controller\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use TurtleCoin\Currency\Helper\Data;
use TurtleCoin\Currency\Model\CoinMarketCapFactory;
use Psr\Log\LoggerInterface;

class ApiTest extends Action
{
    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var Data
     */
    private $helper;

    /**
     * @var CoinMarketCapFactory
     */
    private $coinMarketCap;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param Data $helper
     * @param CoinMarketCapFactory $coinMarketCap
     * @param LoggerInterface $logger
     */
    public function __construct(Context $context, JsonFactory $resultJsonFactory, Data $helper, CoinMarketCapFactory $coinMarketCap, LoggerInterface $logger)
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->helper = $helper;
        $this->coinMarketCap = $coinMarketCap;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * Test CoinMarketCap Api
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $success = false;
        $response = null;

        try {
            $coinMarketCapModel = $this->coinMarketCap->create();
            if($response = $coinMarketCapModel->getExchangeData()) {
                $success = true;
            }

        } catch (\Exception $e) {
            $this->logger->critical($e);
        }

        return $result->setData(['success' => $success, 'data' => $response]);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('TurtleCoin_Currency::config');
    }
}
