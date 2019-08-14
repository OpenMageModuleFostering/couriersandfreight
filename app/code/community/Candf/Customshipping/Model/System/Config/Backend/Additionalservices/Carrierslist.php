<?php

class Candf_Customshipping_Model_System_Config_Backend_Additionalservices_Carrierslist {

    public function toOptionArray() {
        return $this->_options = Mage::getSingleton('customshipping/carrier_dynamic')->getCarrierList(true);
    }

}