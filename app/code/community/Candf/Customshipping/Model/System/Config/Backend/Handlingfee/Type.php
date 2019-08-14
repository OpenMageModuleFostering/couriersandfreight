<?php

class Candf_Customshipping_Model_System_Config_Backend_Handlingfee_Type {

    protected $_options;

    const ACCOUNT  = 'rate';
    const CREDIT  = 'percentage';

    public function toOptionArray()
    {
        return $this->_options = array(
            self::ACCOUNT  => 'rate',
            self::CREDIT  => 'percentage',
        );
    }
}