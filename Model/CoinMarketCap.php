<?php

namespace TurtleCoin\Currency\Model;

use TurtleCoin\Currency\Helper\Data;
use Psr\Log\LoggerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Directory\Model\ResourceModel\Currency;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;

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
     * Allowed currencies for the CoinMarketCap API endpoint
     */
    const ALLOWED_BASE_CURRENCIES = ['USD', 'AUD', 'BRL', 'CAD', 'CHF', 'CLP', 'CNY', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HUF', 'IDR', 'ILS', 'INR', 'JPY', 'KRW', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PKR', 'PLN', 'RUB', 'SEK', 'SGD', 'THB', 'TRY', 'TWD', 'ZAR'];

    /**
     * @var Data
     */
    private $helper;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * @param Data $helper
     * @param LoggerInterface $logger
     * @param StoreManagerInterface $storeManager
     * @param Currency $currency
     */
    public function __construct(Data $helper, LoggerInterface $logger, StoreManagerInterface $storeManager, Currency $currency)
    {
        $this->helper = $helper;
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->currency = $currency;
    }

    /**
     * Get exchange data from CoinMarketCap Api
     *
     * @return array
     */
    public function getExchangeData()
    {
        $baseCurrencyCode = $this->getBaseCurrencyCode();

        if(!$this->helper->getApiKey()) {
            throw InputException::requiredField('API Key');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URL . '?symbol=' . self::SYMBOL . '&convert=' . $baseCurrencyCode);
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
        $baseCurrencyCode = $this->getBaseCurrencyCode();
        $price = 0;

        try {
            $exchangeData = $this->getExchangeData();
            $exchangeRate = $exchangeData['data'][self::SYMBOL]['quote'][$baseCurrencyCode]['price'];
            $price = 1 / $exchangeRate;
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }

        return $price;
    }

    /**
     * Get store base currency code
     *
     * @return string
     */
    public function getBaseCurrencyCode()
    {
        $baseCurrencyCode = $this->storeManager->getStore()->getBaseCurrencyCode();
        if($baseCurrencyCode === self::SYMBOL) {
            throw new LocalizedException('There is no need to get exchange rate data because the base currency is ' . self::SYMBOL);
        } else if (!in_array($baseCurrencyCode, self::ALLOWED_BASE_CURRENCIES)) {
            throw new LocalizedException('The base currency (' . $baseCurrencyCode . ') is not one of the currencies available to the CoinMarketCap API endpoint');
        }

        return $baseCurrencyCode;
    }

    /**
     * Set currency rate
     *
     * @return void
     */
    public function setCurrencyRate()
    {
        $price = $this->getExchangeRate();

        if($price !== 0) {
            $currencyArray = [
                $this->getBaseCurrencyCode() => [
                    self::SYMBOL => $price
                ]
            ];

            $this->currency->saveRates($currencyArray);
        }
    }
}