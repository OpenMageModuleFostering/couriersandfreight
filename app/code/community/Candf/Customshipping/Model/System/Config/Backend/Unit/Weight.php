<?php

class Candf_Customshipping_Model_System_Config_Backend_Unit_Weight {

    protected $_options;

    const KILOGRAMS = 'Kilograms';
    const GRAMS     = 'Grams';
    const OUNCES    = 'Ounces';
    const POUNDS    = 'Pounds';

    function toOptionArray() {

        return $this->_options = array(
            self::KILOGRAMS => 'Kilograms',
            self::GRAMS => 'Grams',
            self::OUNCES => 'Ounces',
            self::POUNDS => 'Pounds'
        );
    }


}