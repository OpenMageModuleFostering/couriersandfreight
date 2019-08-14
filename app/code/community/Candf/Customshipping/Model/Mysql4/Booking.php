<?php

class Candf_Customshipping_Model_Mysql4_Booking extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('customshipping/booking', 'id');
    }

}
