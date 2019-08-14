<?php

class Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Form_Manualycreatebox extends Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Abstract
{

    protected $_addRowButtonHtml = array();
    protected $_removeRowButtonHtml = array();
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $html = '<div id="code_label_textfields_template" style="display:none">';
        $html .= $this->_getRowTemplateHtml();
        $html .= '</div>';
        $html .= '<ul id="code_label_textfields_container">';
        if ($this->_getValue('method')) {
            foreach ($this->_getValue('method') as $i=>$f) {
                if ($i) {
                    $html .= $this->_getRowTemplateHtml($i);
                }
            }
        }
        $html .= '</ul>';
        $html .= $this->_getAddRowButtonHtml('code_label_textfields_container', 'code_label_textfields_template', $this->__('Button Label Here'));
        return $html;
    }

    protected function _getRowTemplateHtml()
    {
        $html = '<li>';
        $html .= '<div style="margin:5px 0 10px;">';
        $html .= '<input class="input-text" name="'.$this->getElement()->getName().'" value="'.$this->_getValue('price/'.$i).'" '.$this->_getDisabled().'/> ';
        $html .= $this->_getRemoveRowButtonHtml();
        $html .= '</div>';
        $html .= '</li>';
        return $html;
    }



    protected function _getDisabled()
    {
        return $this->getElement()->getDisabled() ? ' disabled' : '';
    }

    protected function _getValue($key)
    {
        return $this->getElement()->getData('value/'.$key);
    }

    protected function _getSelected($key, $value)
    {
        return $this->getElement()->getData('value/'.$key)==$value ? 'selected="selected"' : '';
    }

    protected function _getAddRowButtonHtml($container, $template, $title='Add')
    {
        if (!isset($this->_addRowButtonHtml[$container])) {
            $this->_addRowButtonHtml[$container] = $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setType('button')
                ->setClass('add '.$this->_getDisabled())
                ->setLabel($this->__($title))
                ->setOnClick("Element.insert($('".$container."'), {bottom: $('".$template."').innerHTML})")
                ->setDisabled($this->_getDisabled())
                ->toHtml();
        }
        return $this->_addRowButtonHtml[$container];
    }

    protected function _getRemoveRowButtonHtml($selector='li', $title='Remove')
    {
        if (!$this->_removeRowButtonHtml) {
            $this->_removeRowButtonHtml = $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setType('button')
                ->setClass('delete v-middle '.$this->_getDisabled())
                ->setLabel($this->__($title))
                ->setOnClick("Element.remove($(this).up('".$selector."'))")
                ->setDisabled($this->_getDisabled())
                ->toHtml();
        }
        return $this->_removeRowButtonHtml;
    }

}