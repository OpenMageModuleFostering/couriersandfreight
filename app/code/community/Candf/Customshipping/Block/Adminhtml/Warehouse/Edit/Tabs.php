<?php

class Candf_Customshipping_Block_Adminhtml_Warehouse_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('warehouse_id');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('customshipping')->__('Warehouse Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_general', array(
            'label'     => Mage::helper('customshipping')->__('Genaral Information'),
            'title'     => Mage::helper('customshipping')->__('Genaral Information'),
            'content'   => $this->getLayout()->createBlock('customshipping/adminhtml_warehouse_edit_tab_genaral')->toHtml(),
        ));

        $this->addTab('form_address', array(
            'label'     => Mage::helper('customshipping')->__('Address & Contact'),
            'title'     => Mage::helper('customshipping')->__('Address & Contact'),
            'content'   => $this->getLayout()->createBlock('customshipping/adminhtml_warehouse_edit_tab_address')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
?>