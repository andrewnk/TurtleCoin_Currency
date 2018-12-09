<?php

namespace TurtleCoin\Currency\Model\Config\Backend\Currency;

class Allow extends \Magento\Config\Model\Config\Backend\Currency\Allow
{
    /**
     * Add TRTL to array of installed allowed currencies
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
