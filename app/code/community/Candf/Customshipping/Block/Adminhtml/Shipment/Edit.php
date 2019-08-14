<?php

class Candf_Customshipping_Block_Adminhtml_Shipment_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    protected $_shipment;

    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'customshipping';
        $this->_controller = 'adminhtml_shipment';

        if ($this->getShipment()->getStatus() != Candf_Customshipping_Model_System_Config_Backend_Shipment_Status::BOOKED){
            $this->_updateButton('save', 'label', Mage::helper('customshipping')->__('Save and Get Quotes'));
        } else if($this->getShipment()->getStatus() == Candf_Customshipping_Model_System_Config_Backend_Shipment_Status::BOOKED){
            $this->removeButton('save');
        }


        $this->removeButton('delete');
        $this->removeButton('reset');

        $add_button_method = 'addButton';
        if (!method_exists($this, $add_button_method)) {
            $add_button_method = '_addButton';
        }

    }

    public function getShipment()
    {
        if (!$this->_shipment) {
            $this->_shipment = Mage::registry('customshipping_shipment_data');
        }
        return $this->_shipment;
    }

    /**
     * Gets the current order for the shipment being edited.
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        if ($this->hasOrder()) {
            return $this->getData('order');
        }
        if (Mage::registry('current_order')) {
            return Mage::registry('current_order');
        }
        if (Mage::registry('order')) {
            return Mage::registry('order');
        }
        Mage::throwException(Mage::helper('sales')->__('Cannot get order instance'));
    }
}