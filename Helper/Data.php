<?php

namespace TurtleCoin\Currency\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends AbstractHelper
{
    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * @param ScopeConfigInterface $scope
     * @return string
     */
    public function getApiKey($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue('turtlecoin/currency/apikey', $scope);
    }
}
