<?php

abstract class Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Abstract extends Mage_Adminhtml_Block_Template
{

    protected $_helper = null;

    public function __construct()
    {
        parent::_construct();
        $this->setParentBlock(Mage::getBlockSingleton('customshipping/adminhtml_shipment_edit'));
    }

    /**
     * Gets the shipment being edited.
     *
     */
    public function getShipment()
    {
        return $this->getParentBlock()->getShipment();
    }

    /**
     * Gets the saved quotes for this order from the database.
     *
     */
    public function getQuotes()
    {
        //print_r($this->getShipment());
        return $this->getShipment()->getQuotes(true);
    }

    public function formatCurrency($price)
    {
        return Mage::helper('core')->currency($price);
    }

    public function getWeightUnitText($unit = null)
    {
        if (!$unit) {
            $unit = $this->getCustomshippingHelper()->getConfigData('units/weight');
        }
        return Mage::getModel('customshipping/system_config_backend_unit_weight')
            ->getBriefOptionLabel($unit);
    }

    public function getMeasureUnitText($unit = null)
    {
        if (!$unit) {
            $unit = $this->getCustomshippingHelper()->getConfigData('units/measure');
        }
        return Mage::getModel('customshipping/system_config_backend_unit_measure')
            ->getBriefOptionLabel($unit);
    }

    public function getCustomshippingHelper() {
        if (!$this->_helper) {
            $this->_helper = Mage::helper('customshipping');
        }
        return $this->_helper;
    }

}
