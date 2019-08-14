<?php

class Candf_Customshipping_Block_Adminhtml_Zone extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_zone';
        $this->_blockGroup = 'customshipping';
        $this->_headerText = Mage::helper('customshipping')->__('Manage Zone');
        $this->_addButtonLabel = Mage::helper('customshipping')->__('Add Item');
        parent::__construct();
    }

}


