<?php

class Candf_Customshipping_Model_System_Config_Backend_Unit_Measure {


    protected $_options;

    const CENTIMETRES = 'Centimetres';
    const METRES      = 'Meters';
    const INCHES      = 'Inches';
    const FEET        = 'Feet';

    public function toOptionArray() {
        return $this->_options = array(
            self::CENTIMETRES  => 'Centimetres',
            self::METRES  => 'Meters',
            self::INCHES => 'Inches',
            self::FEET => 'Feet',
        );
    }
}
