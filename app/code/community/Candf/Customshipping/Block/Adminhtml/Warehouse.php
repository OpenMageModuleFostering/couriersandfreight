<?php

class Candf_Customshipping_Block_Adminhtml_Warehouse extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_warehouse';
        $this->_blockGroup = 'customshipping';
        $this->_headerText = Mage::helper('customshipping')->__('Manage Warehouse');
        $this->_addButtonLabel = Mage::helper('customshipping')->__('Add Item');
        parent::__construct();
    }

}
