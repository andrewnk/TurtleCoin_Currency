<?php

namespace TurtleCoin\Currency\Model\Framework;

use Magento\Framework\App\CacheInterface;

class Currency extends \Magento\Framework\Currency
{
    public function __construct(CacheInterface $appCache, $options = null, $locale = null)
    {
        if ($options == "TRTL") {
            $options = array();
            $options["precision"] = 0;
            $options["name"] = "TurtleCoin";
            $options["currency"] = "TRTL";
            $options["symbol"] = "TRTL";
            $options["format"] = "#,##0.00 ¤";
        }

        parent::__construct($appCache, $options, $locale);
    }

    public function toCurrency($value = null, array $options = array())
    {
        $locale = $this->getLocale();
        if ($this->_options['currency'] == 'TRTL') {
            $options["precision"] = 2;
        }
        $currencyStr = trim(parent::toCurrency($value, $options));

        return $currencyStr;
    }
}
