<?php

class Candf_Customshipping_Model_System_Config_Backend_Insurance {

    protected $_options;

    const DISABLED  = 'disabled';
    const OPTIONAL  = 'optional';
    const MANDATORY = 'mandatory';

    public function toOptionArray() {
        return $this->_options = array(
            self::DISABLED  => 'Disabled',
            self::OPTIONAL  => 'Optional',
            self::MANDATORY => 'Mandatory',
        );
    }

}
