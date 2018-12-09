<?php

namespace TurtleCoin\Currency\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class ApiTest extends Field
{
    /**
     * @var string
     */
    protected $_template = 'TurtleCoin_Currency::system/config/apitest.phtml';

    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Remove scope label
     *
     * @param  AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     *
     * @param  AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * Return route url to our apitest controller method
     *
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl('turtlecoin_currency/system_config/apitest');
    }

    /**
     * Generate button html
     *
     * @return string
     */
    public function getButtonHtml()
    {
        $data = [
            'id' => 'apitest_button',
            'label' => __('Test API')
        ];

        $button = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Button')->setData($data);

        return $button->toHtml();
    }
}
