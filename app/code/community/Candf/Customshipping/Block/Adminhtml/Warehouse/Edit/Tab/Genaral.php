<?php

class Candf_Customshipping_Block_Adminhtml_Warehouse_Edit_Tab_Genaral extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('warehouse_genaral', array('legend'=>Mage::helper('customshipping')->__('Genaral Details')));


        $fieldset->addField('name', 'text', array(
            'name' => 'name',
            'label' => Mage::helper('customshipping')->__('Name'),
            'title' => Mage::helper('customshipping')->__('Name'),
            'required' => true,
        ));

        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('customshipping')->__('Status'),
            'title'     => Mage::helper('customshipping')->__('Status'),
            'name'      => 'is_active',
            'required' => true,
            'options'    => array(
                '1' => Mage::helper('customshipping')->__('Enabled'),
                '0' => Mage::helper('customshipping')->__('Disabled'),
            ),
        ));

        $fieldset->addField('company_name', 'text', array(
            'name' => 'company_name',
            'label' => Mage::helper('customshipping')->__('Company Name'),
            'title' => Mage::helper('customshipping')->__('Company Name'),
            'required' => true,
        ));

        if ( Mage::getSingleton('adminhtml/session')->getWarehouseData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getWarehouseData());
            Mage::getSingleton('adminhtml/session')->setWarehouseData(null);
        } elseif ( Mage::registry('warehouse_data') ) {
            $form->setValues(Mage::registry('warehouse_data')->getData());
        }
        return parent::_prepareForm();
    }
}
?>