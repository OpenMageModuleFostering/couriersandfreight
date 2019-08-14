<?php

class Candf_Customshipping_Model_Warehouse extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customshipping/warehouse');
    }
}
?>