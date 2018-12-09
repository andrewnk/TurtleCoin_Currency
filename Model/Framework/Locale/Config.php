<?php

namespace TurtleCoin\Currency\Model\Framework\Locale;

class Config extends \Magento\Framework\Locale\Config
{
    /**
     * @inheritdoc
     */
    public function getAllowedCurrencies()
    {
        $this->_allowedCurrencies[] = 'TRTL';
        return $this->_allowedCurrencies;
    }
}
