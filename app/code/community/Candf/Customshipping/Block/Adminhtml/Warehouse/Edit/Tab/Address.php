<?php

class Candf_Customshipping_Block_Adminhtml_Warehouse_Edit_Tab_Address extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('warehouse_address', array('legend'=>Mage::helper('customshipping')->__('Address Details')));

        $fieldset->addField('street_add1', 'text', array(
            'label'     => Mage::helper('customshipping')->__('Street Address 1'),
            'class'     => 'required-entry',
            'name'      => 'street_add1',
        ));


        $fieldset->addField('street_add2', 'text', array(
            'label'     => Mage::helper('customshipping')->__('Street Address 2'),
            'class'     => 'required-entry',
            'name'      => 'street_add2',
        ));


        $fieldset->addField('zip', 'text', array(
            'label'     => Mage::helper('customshipping')->__('Zip/Post Code'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'zip',
        ));

        $fieldset->addField('suburb', 'text', array(
            'label'     => Mage::helper('customshipping')->__('Warehouse Suburb'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'suburb',
        ));
        $fieldset->addField('state', 'text', array(
            'label'     => Mage::helper('customshipping')->__('State'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'state',
        ));
        $fieldset->addField('country', 'text', array(
            'label'     => Mage::helper('customshipping')->__('Country'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'country',
        ));

        $fieldset = $form->addFieldset('warehouse_contact', array('legend'=>Mage::helper('customshipping')->__('Contact Details')));

        $fieldset->addField('contact_name', 'text', array(
            'label'     => Mage::helper('customshipping')->__('Contact Name'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'contact_name',
        ));

        $fieldset->addField('contact_email', 'text', array(
            'label'     => Mage::helper('customshipping')->__('Contact Email'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'contact_email',
        ));

        $fieldset->addField('phone1', 'text', array(
            'label'     => Mage::helper('customshipping')->__('Phone 1'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'phone1',
        ));

        $fieldset->addField('phone2', 'text', array(
            'label'     => Mage::helper('customshipping')->__('Phone 2'),
            'required'  => true,
            'name'      => 'phone2',
        ));

        $fieldset->addField('fax', 'text', array(
            'label'     => Mage::helper('customshipping')->__('Fax'),
            'required'  => true,
            'name'      => 'fax',
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