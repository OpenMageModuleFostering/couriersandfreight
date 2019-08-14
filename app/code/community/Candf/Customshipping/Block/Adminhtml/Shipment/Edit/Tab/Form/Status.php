<?php

class Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Form_Status extends Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Abstract
{
    
    protected $_customer_selected_quote = null;
    
    public function getCustomerSelectedQuoteDescription()
    {
        return $this->getShipment()->getCustomerSelectedQuoteDescription();
    }

    public function getCandfShipmentStatus()
    {
        return Mage::getModel('customshipping/system_config_backend_shipment_status')
            ->getOptionLabel($this->getShipment()->getStatus());
    }

}
