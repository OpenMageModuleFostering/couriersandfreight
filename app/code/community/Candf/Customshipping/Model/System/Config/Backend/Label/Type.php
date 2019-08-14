<?php

class Candf_Customshipping_Model_System_Config_Backend_label_Type {

    protected $_options;

    const PLAIN = 'Plain';
    const THERMAL = 'Thermal';

    public function toOptionArray() {
        return $this->_options = array(
            self::PLAIN => 'Plain',
            self::THERMAL => 'Thermal'
        );

    }
}
