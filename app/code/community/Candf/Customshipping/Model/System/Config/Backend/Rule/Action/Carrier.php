<?php

class Candf_Customshipping_Model_System_Config_Backend_Rule_Action_Carrier
{
    protected $_options;

    const PREFERABLE_CARRIERS          = "All";
    const EXPRESS_CARRIERS             = "Express";
    const SAME_DAY_CARRIERS            = "Sameday";

    public  function toOptionArray()
    {
       return $this->_options = array(
            self::PREFERABLE_CARRIERS   => 'Preferable Carriers',
            self::EXPRESS_CARRIERS      => 'Express Carriers',
            self::SAME_DAY_CARRIERS     => 'Same Day Carriers'
        );
    }
}