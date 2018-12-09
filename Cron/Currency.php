<?php

namespace TurtleCoin\Currency\Cron;

use Psr\Log\LoggerInterface;
use TurtleCoin\Currency\Helper\Data;
use TurtleCoin\Currency\Model\CoinMarketCapFactory;

class Currency
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Data
     */
    private $helper;

    /**
     * @var CoinMarketCapFactory
     */
    private $coinMarketCap;

    /**
     * @param LoggerInterface $logger
     * @param Data $helper
     * @param CoinMarketCapFactory $coinMarketCap
     */
    public function __construct(LoggerInterface $logger, Data $helper, CoinMarketCapFactory $coinMarketCap)
    {
        $this->logger = $logger;
        $this->helper = $helper;
        $this->coinMarketCap = $coinMarketCap;
    }

  /**
   * Set exchange rate
   *
   * @return void
   */
    public function execute()
    {
        //don't run anything if an api key hasn't been set
        if(!$this->helper->getApiKey()) {
          return;
        }

        try {
          $coinMarketCapModel = $this->coinMarketCap->create();
          $coinMarketCapModel->setCurrencyRate();
          $this->logger->info('TurtleCoin exchange rate updated');
        } catch (\Exception $e) {
          $this->logger->critical($e);
        }
    }
}
