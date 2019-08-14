<?php

class Candf_Customshipping_Model_Mysql4_Boxes extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('customshipping/boxes', 'boxes_id');
    }
}
?>