<?php

class Candf_Customshipping_Block_Adminhtml_Rule_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
	parent::__construct();
	$this->setId('customshipping_rule_edit_tabs');
	$this->setDestElementId('edit_form');
	$this->setTitle(Mage::helper('customshipping')->__('Rule Configuration'));
    }
}
