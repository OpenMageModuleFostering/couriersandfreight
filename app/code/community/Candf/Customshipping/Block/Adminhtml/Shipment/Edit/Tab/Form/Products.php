<?php

class Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Form_Products extends Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Abstract
{

    public function getProductFromItem(Mage_Sales_Model_Order_Item $item)
    {
        return Mage::getModel('catalog/product')
            ->load($item->getProductId());
    }

}
