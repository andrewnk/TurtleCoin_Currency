<?php

namespace TurtleCoin\Currency\Model\Framework\Locale;

class Format extends \Magento\Framework\Locale\Format
{
    /**
     * Returns an array with price formatting info
     *
     * @param string $localeCode Locale code.
     * @param string $currencyCode Currency code.
     * @return array
     */
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
            $_format['precision'] = 0;
            $_format['requiredPrecision'] = 0;
        }

        return $_format;
    }
}
