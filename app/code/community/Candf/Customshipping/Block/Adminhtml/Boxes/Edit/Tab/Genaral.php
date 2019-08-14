<?php

class Candf_Customshipping_Block_Adminhtml_Boxes_Edit_Tab_Genaral extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('boxes_genaral', array('legend'=>Mage::helper('customshipping')->__('Genaral Details')));


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

        $fieldset->addField('length', 'text', array(
            'name' => 'length',
            'label' => Mage::helper('customshipping')->__('Box Length'),
            'title' => Mage::helper('customshipping')->__('Box Length'),
            'required' => true,
        ));
        $fieldset->addField('width', 'text', array(
            'name' => 'width',
            'label' => Mage::helper('customshipping')->__('Box Width'),
            'title' => Mage::helper('customshipping')->__('Box Width'),
            'required' => true,
        ));
        $fieldset->addField('height', 'text', array(
            'name' => 'height',
            'label' => Mage::helper('customshipping')->__('Box Height'),
            'title' => Mage::helper('customshipping')->__('Box Height'),
            'required' => true,
        ));

        if ( Mage::getSingleton('adminhtml/session')->getBoxesData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBoxesData());
            Mage::getSingleton('adminhtml/session')->setBoxesData(null);
        } elseif ( Mage::registry('boxes_data') ) {
            $form->setValues(Mage::registry('boxes_data')->getData());
        }
        return parent::_prepareForm();
    }
}
?>