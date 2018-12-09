<?php

namespace TurtleCoin\Currency\Model\Config\Backend\Currency;

class Base extends \Magento\Config\Model\Config\Backend\Currency\Base
{
    /**
     * Add TRTL to array of installed base currencies
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
