<?php

class Candf_Customshipping_Model_System_Config_Backend_Rule_Action_filter
{
    protected $_options;

    const DYNAMIC_ALL                  = 1;
    const DYNAMIC_FASTEST              = 2;
    const DYNAMIC_CHEAPEST             = 3;
    const DYNAMIC_FASTEST_AND_CHEAPEST = 4;

    public function toOptionArray()
    {
        return $this->_options = array(
            self::DYNAMIC_ALL                  => 'All Quotes',
            self::DYNAMIC_CHEAPEST             => 'Cheapest only',
            self::DYNAMIC_FASTEST              => 'Fastest only',
            self::DYNAMIC_FASTEST_AND_CHEAPEST => 'Cheapest and Fastest only',
        );
    }
}