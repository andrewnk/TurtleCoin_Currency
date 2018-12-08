<?php

namespace TurtleCoin\Currency\Model\Framework\Locale;

class Format extends \Magento\Framework\Locale\Format
{
    public function getPriceFormat($localeCode = null, $currencyCode = null)
    {
        $currency = $this->_scopeResolver->getScope()->getCurrentCurrency();
        $_currencyCode = $currency->getCurrencyCode();

        if ($currencyCode) {
            $currency = $this->currencyFactory->create()->load($currencyCode);
            $_currencyCode = $currencyCode;
        }

        $_format = parent::getPriceFormat($localeCode, $currencyCode);

        if($_currencyCode === 'TRTL'){
            $_format["precision"] = 0;
            $_format["requiredPrecision"] = 0;
        }

        return $_format;
    }
}
