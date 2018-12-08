<?php

namespace TurtleCoin\Currency\Model;

use TurtleCoin\Currency\Helper\Data;
use Psr\Log\LoggerInterface;

class CoinMarketCap
{
    /**
     * TurtleCoin symbol for CoinMarketCap
     */
    const SYMBOL = 'TRTL';

    /**
     * CoinMarketCap API Url
     */
    const URL = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';

    /**
     * @var Data
     */
    private $helper;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Base Currency to convert to
     */
    private $convert;

    /**
     * @param Data $helper
     * @param LoggerInterface $logger
     */
    public function __construct(Data $helper, LoggerInterface $logger)
    {
        $this->helper = $helper;
        $this->logger = $logger;
        $this->convert = 'USD';
    }

    /**
     * Get exchange data from CoinMarketCap Api
     *
     * @return array
     */
    public function getExchangeData()
    {
        if(!$this->helper->getApiKey()) {
            $this->logger->critical('An API Key is required to query the CoinMarketCap API');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URL . '?symbol=' . self::SYMBOL . '&convert=' . $this->convert);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        $headers = [
            'Content-Type: application/json',
            'X-CMC_PRO_API_KEY: ' . $this->helper->getApiKey()
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        try {
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                $this->logger->critical('There was a problem querying the API: ' . curl_error($ch));
            }

            curl_close ($ch);
            return json_decode($response, true);
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }
    }

    /**
     * Get exchange rate from CoinMarketCap Api given the base currency
     *
     * @return float
     */
    public function getExchangeRate()
    {
        //TODO
        //get magento base currency for echange rate
    }
}
