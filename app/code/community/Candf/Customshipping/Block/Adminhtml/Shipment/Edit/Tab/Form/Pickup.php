<?php

class Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Form_Pickup extends Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Abstract
{
    public function isAdminSelect()
    {
        if ($this->getShipment() && !is_null(Mage::getSingleton('adminhtml/session')->getData('pickup_' . $this->getShipment()->getId()))) {
            return true;
        }

        return false;
    }

}
