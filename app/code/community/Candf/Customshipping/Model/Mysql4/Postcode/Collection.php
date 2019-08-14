<?php

class Candf_Customshipping_Model_Mysql4_Postcode_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct() {
        parent::_construct();
        $this->_init('customshipping/postcode');
    }
}