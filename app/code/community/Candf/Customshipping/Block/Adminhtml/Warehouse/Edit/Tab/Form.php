<?php

class Candf_Customshipping_Block_Adminhtml_Warehouse_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('warehouse_address', array('legend'=>Mage::helper('customshipping')->__('Address Details')));


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

        $fieldset->addField('location_type', 'select', array(
            'name' => 'location_type',
            'label' => Mage::helper('customshipping')->__('Location Type'),
            'title' => Mage::helper('customshipping')->__('Location Type'),
            'required' => true,
//            'values' => Mage::getSingleton('customshipping/system_config_source_origin_type')->getOptions(),
        ));

        $fieldset->addField('priority', 'text', array(
            'name' => 'priority',
            'label' => Mage::helper('customshipping')->__('Priority'),
            'title' => Mage::helper('customshipping')->__('Priority'),
            'required' => false,
            'class' => 'validate-digits',
        ));

        $field = $fieldset->addField('store_ids', 'multiselect', array(
            'name'     => 'store_ids[]',
            'label'     => Mage::helper('customshipping')->__('Stores'),
            'title'     => Mage::helper('customshipping')->__('Stores'),
            'required' => true,
            'values'   => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm()
        ));
        $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
        $field->setRenderer($renderer);


        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
?>