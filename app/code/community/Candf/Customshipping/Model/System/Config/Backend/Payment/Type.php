<?php
class Candf_Customshipping_Model_System_Config_Backend_Payment_Type {

    protected $_options;

    const ACCOUNT  = 'account';
    const CREDIT  = 'credit';

    public function toOptionArray() {
        return $this->_options = array(
            self::ACCOUNT  => 'account',
            self::CREDIT  => 'credit',
        );
    }
}