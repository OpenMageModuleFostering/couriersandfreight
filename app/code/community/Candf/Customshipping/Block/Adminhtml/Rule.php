<?php

class Candf_Customshipping_Block_Adminhtml_Rule extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'customshipping';
        $this->_controller = 'adminhtml_rule';
        $this->_headerText = Mage::helper('customshipping')->__('Manage Rules');
        $this->_addButtonLabel = Mage::helper('customshipping')->__('Add New Rule');
        parent::__construct();
    }
}
