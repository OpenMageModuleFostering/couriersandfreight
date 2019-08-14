<?php

class Candf_Customshipping_Model_Mysql4_Warehouse extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('customshipping/warehouse', 'warehouse_id');
    }
}
?>