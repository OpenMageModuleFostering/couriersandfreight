<?php

class Candf_Customshipping_Block_Adminhtml_Rule_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    
    public function __construct()
    {
	$this->_objectId = 'id';
        $this->_blockGroup = 'customshipping';
        $this->_controller = 'adminhtml_rule';
        parent::__construct();

	$this->_addButton('save_and_continue_edit', array(
            'class'   => 'save',
            'label'   => Mage::helper('customshipping')->__('Save and Continue Edit'),
            'onclick' => 'editForm.submit($(\'edit_form\').action + \'back/edit/\')',
        ), 10);
    } 

    /**
     * Getter for form header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if( Mage::registry('rule_data') && Mage::registry('rule_data')->getId()) {
			return Mage::helper('customshipping')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('rule_data')->getTitle()));
		} else {
			return Mage::helper('customshipping')->__('Add Item');
		}
    }
}
