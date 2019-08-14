<?php

class MagePsycho_Shipmentfilter_Model_Shipping extends Mage_Shipping_Model_Shipping
{
    public function collectCarrierRates($carrierCode, $request) {
        if (!$this->_checkCarrierAvailability($carrierCode, $request)) {
        return $this;
        }
        return parent::collectCarrierRates($carrierCode, $request);
    }

    protected function _checkCarrierAvailability($carrierCode, $request = null){
    $isLoggedIn  = Mage::getSingleton('customer/session')->isLoggedIn();
    if(!$isLoggedIn){
        if($carrierCode == 'flatrate'){ #Hide Flat Rate for non logged in customers
            return false;
        }
    }
        return true;
    }
}