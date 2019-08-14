<?php

class Candf_Customshipping_Block_Adminhtml_Boxes extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_boxes';
        $this->_blockGroup = 'customshipping';
        $this->_headerText = Mage::helper('customshipping')->__('Manage Boxes');
        $this->_addButtonLabel = Mage::helper('customshipping')->__('Add Item');
        parent::__construct();
    }

}
