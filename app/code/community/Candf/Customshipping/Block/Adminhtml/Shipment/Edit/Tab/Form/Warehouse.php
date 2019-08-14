<?php

class Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Form_Warehouse extends Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Abstract
{
    public function getMultipleWarehouse() {
        $warehouse = Mage::getModel('customshipping/warehouse')->getCollection()->getData();
        return $warehouse;

    }
}