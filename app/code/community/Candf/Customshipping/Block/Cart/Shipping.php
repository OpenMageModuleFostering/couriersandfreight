<?php

class Candf_Customshipping_Block_Cart_Shipping extends Mage_Core_Block_Abstract
{

    public function getCityActive()
    {
        return (bool)Mage::getStoreConfig('carriers/dhl/active')
        || (bool)Mage::getStoreConfig('carriers/dhlint/active');
    }

}