<?php

namespace TurtleCoin\Currency\Model\Config\Backend\Currency;

class DefaultCurrency extends \Magento\Config\Model\Config\Backend\Currency\DefaultCurrency
{
    /**
     * Add TRTL to array of default currencies
     *
     * @return string[]
     */
    protected function _getInstalledCurrencies()
    {
        $_installed = parent::_getInstalledCurrencies();
        array_unshift($_installed, 'TRTL');
        return $_installed;
    }
}
