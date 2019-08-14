<?php

class Candf_Customshipping_Block_Adminhtml_System_Config_Backend_Form_Field_Required extends Mage_Adminhtml_Block_System_Config_Form_Field {

    protected $_element;

    public function render(Varien_Data_Form_Element_Abstract $element) {

        $this->_element = $element;

        $html = parent::render($this->_element);

        $html = $this->_addValidateStar($html);

        return $html;
    }

    public function _addValidateStar($html) {
        $search = '<label for="' . $this->_element->getHtmlId() . '">' . $this->_element->getLabel() . '</label>';
        $replacement = '<label for="' . $this->_element->getHtmlId() . '">' . $this->_element->getLabel() . ' <span class="required">*</span></label>';

        return str_replace($search, $replacement, $html);
    }

}
