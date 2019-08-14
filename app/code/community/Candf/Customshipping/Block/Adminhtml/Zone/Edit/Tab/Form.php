<?php
 
class Candf_Customshipping_Block_Adminhtml_Zone_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('zone_form', array('legend'=>Mage::helper('customshipping')->__('Item information')));
	   
		$fieldset->addField('name', 'text', array(
			'label'     => Mage::helper('customshipping')->__('Name'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'name',
		));
		
		$fieldset->addField('street', 'text', array(
			'label'     => Mage::helper('customshipping')->__('Street'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'street',
		));
		
		$fieldset->addField('city', 'text', array(
			'label'     => Mage::helper('customshipping')->__('City'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'city',
		));
		
		$fieldset->addField('zip', 'text', array(
			'label'     => Mage::helper('customshipping')->__('Zip/Post Code'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'zip',
		));
		
		$fieldset->addField('region', 'text', array(
			'label'     => Mage::helper('customshipping')->__('Region'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'region',
		));
		
		$fieldset->addField('country', 'text', array(
			'label'     => Mage::helper('customshipping')->__('Country'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'country',
		));
 
	
	   
		if ( Mage::getSingleton('adminhtml/session')->getZoneData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getZoneData());
			Mage::getSingleton('adminhtml/session')->setZoneData(null);
		} elseif ( Mage::registry('zone_data') ) {
			$form->setValues(Mage::registry('zone_data')->getData());
		}
		return parent::_prepareForm();
	}
}
?>