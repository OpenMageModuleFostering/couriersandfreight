<?php

class Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Form_Availableboxes extends Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Abstract
{
    public function getAvailableboxes() {
        $warehouse = Mage::getModel('customshipping/boxes')->getCollection()->setOrder('width', 'asc');
        $warehouse->addFieldToFilter( 'is_active', '1' );
        $warehouse->getData();
        return $warehouse;

    }
}