<?php

class Candf_Customshipping_Block_Adminhtml_Shipment extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct() {
        $this->_controller = 'adminhtml_shipment';
        $this->_blockGroup = 'customshipping';
        $this->_headerText = Mage::helper('customshipping')->__('Manage Shipments');
        parent::__construct();
        $this->_removeButton('add');

    }
}