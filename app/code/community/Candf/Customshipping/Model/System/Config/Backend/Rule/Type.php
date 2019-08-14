<?php

class Candf_Customshipping_Model_System_Config_Backend_Rule_Type
{
    protected $_options;

    const FLATRATE = '1';
    const FREE	   = '2';
    const DYNAMIC  = '3';
    const RESTRICT = '4';

    public function toOptionArray() {
        return $this->_options = array(
            self::FLATRATE => Mage::helper('customshipping')->__('Flat Rate'),
            self::FREE	   => Mage::helper('customshipping')->__('Free Shipping'),
            self::DYNAMIC  => Mage::helper('customshipping')->__('Dynamic'),
            self::RESTRICT => Mage::helper('customshipping')->__('Restrict'),
        );
    }

}