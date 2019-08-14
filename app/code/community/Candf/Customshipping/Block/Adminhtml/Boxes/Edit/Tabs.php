<?php

class Candf_Customshipping_Block_Adminhtml_Boxes_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('boxes_id');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('customshipping')->__('Boxes Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_general', array(
            'label'     => Mage::helper('customshipping')->__('Genaral Information'),
            'title'     => Mage::helper('customshipping')->__('Genaral Information'),
            'content'   => $this->getLayout()->createBlock('customshipping/adminhtml_boxes_edit_tab_genaral')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
?>