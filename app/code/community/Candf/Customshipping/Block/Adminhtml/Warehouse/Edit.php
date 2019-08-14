<?php

class Candf_Customshipping_Block_Adminhtml_Warehouse_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'customshipping';
        $this->_controller = 'adminhtml_warehouse';

        $this->_updateButton('save', 'label', Mage::helper('customshipping')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('customshipping')->__('Delete Item'));
    }

    public function getHeaderText()
    {
        if( Mage::registry('warehouse_data') && Mage::registry('warehouse_data')->getId() ) {
            return Mage::helper('customshipping')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('warehouse_data')->getTitle()));
        } else {
            return Mage::helper('customshipping')->__('Add Item');
        }
    }
}
