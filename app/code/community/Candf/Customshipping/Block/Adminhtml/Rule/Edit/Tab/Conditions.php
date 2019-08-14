<?php

class Candf_Customshipping_Block_Adminhtml_Rule_Edit_Tab_Conditions
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare content for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('customshipping')->__('Conditions');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('customshipping')->__('Conditions');
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('rule_data');
        
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('rule_');

        $fieldset = $form->addFieldset('conditions_fieldset', array(
            'legend'=>Mage::helper('customshipping')->__('Conditions Configuration (Leave blank for any. Use colon to enter range, comma to separate ranges).')
        ));
	
	$fieldset->addField('condition_weight', 'text', array(
	    'label' => Mage::helper('customshipping')->__('Total Weight'),
	    'title' => Mage::helper('customshipping')->__('Total Weight'),
	    'name'  => 'condition_weight',
	    'class' => 'validate-range-multi-decimal',
	    'note'  => Mage::helper('customshipping')->__('Units as configured in \'Customshipping Settings\' in System Configuration'),
	));
	
	$fieldset->addField('condition_subtotal', 'text', array(
	    'label' => Mage::helper('customshipping')->__('Cart Subtotal'),
	    'title' => Mage::helper('customshipping')->__('Cart Subtotal'),
	    'name'  => 'condition_subtotal',
	    'class' => 'validate-range-multi-decimal',
	    'note'  => Mage::helper('customshipping')->__('ie \'0:49.95\' for up to $49.95'),
	));
	
	$fieldset->addField('condition_items', 'text', array(
	    'label' => Mage::helper('customshipping')->__('Cart Total Items'),
	    'title' => Mage::helper('customshipping')->__('Cart Total Items'),
	    'name'  => 'condition_items',
	    'class' => 'validate-range-multi',
	    'note'  => Mage::helper('customshipping')->__('ie \'1:5\' for 1 to 5 items in the cart'),
	));
	
	$fieldset->addField('condition_zone', 'textarea', array(
	    'label' => Mage::helper('customshipping')->__('Postcode Range'),
	    'title' => Mage::helper('customshipping')->__('Postcode Range'),
	    'name'  => 'condition_zone',
	    'class' => 'validate-range-multi',
	    'note' => Mage::helper('customshipping')->__('ie \'2000:2200,3000,2600:2699\'')
	));
	
	$fieldset->addField('condition_time_type', 'select', array(
            'name'      => 'condition_time_type',
            'label'     => Mage::helper('customshipping')->__('Order Placed (time)'),
            'title'     => Mage::helper('customshipping')->__('Order Placed (time)'),
        ));

        $fieldset->addField('condition_time_value', 'time', array(
            'name'      => 'condition_time_value',
            'label'     => Mage::helper('customshipping')->__('Time'),
            'title'     => Mage::helper('customshipping')->__('Time'),
	    'note'	=> Mage::helper('customshipping')->__('24HH:MM:SS'),
        ));
	
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
