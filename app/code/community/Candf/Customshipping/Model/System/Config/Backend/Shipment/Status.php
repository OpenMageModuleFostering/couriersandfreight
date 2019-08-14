<?php


class Candf_Customshipping_Model_System_Config_Backend_Shipment_Status extends Candf_Customshipping_Model_System_Config_Backend
{

    const PENDING =   '0';
    const BOOKED =    '1';
    const CANCELLED = '2';

    protected function _setupOptions()
    {
        $this->_options = array(
            self::PENDING   => Mage::helper('customshipping')->__('Pending'),
            self::BOOKED    => Mage::helper('customshipping')->__('Booked'),
            self::CANCELLED => Mage::helper('customshipping')->__('Cancelled'),
        );
    }

}