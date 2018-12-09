<?php

namespace TurtleCoin\Currency\Model\Framework;

use Magento\Framework\App\CacheInterface;

class Currency extends \Magento\Framework\Currency
{
    /**
     * @param CacheInterface $appCache
     * @param string $options OPTIONAL
     * @param string $locale OPTIONAL
     */
    public function __construct(CacheInterface $appCache, $options = null, $locale = null)
    {
        if ($options === 'TRTL') {
            $options = [
                'precision' => 0,
                'name'      => 'TurtleCoin',
                'currency'  => 'TRTL',
                'symbol'    => 'TRTL',
                'format'    => '#,##0.00 ¤'
            ];
        }

        parent::__construct($appCache, $options, $locale);
    }

    /**
     * Returns a localized currency string for TRTL
     *
     * @param  integer|float $value   OPTIONAL Currency value
     * @param  array         $options OPTIONAL options to set temporary
     * @throws \Zend_Currency_Exception When the value is not a number
     * @return string
     */
    public function toCurrency($value = null, array $options = array())
    {
        $locale = $this->getLocale();
        if ($this->_options['currency'] === 'TRTL') {
            $options["precision"] = 2;
        }
        $currencyStr = trim(parent::toCurrency($value, $options));

        return $currencyStr;
    }
}
