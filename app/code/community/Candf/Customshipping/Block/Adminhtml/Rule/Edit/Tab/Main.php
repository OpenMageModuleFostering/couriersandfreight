<?php

class Candf_Customshipping_Block_Adminhtml_Rule_Edit_Tab_Main
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
        return Mage::helper('customshipping')->__('Rule Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('customshipping')->__('Rule Information');
    }

    /**
     * Returns status flag about this tab can be showed or not
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

        $fieldset = $form->addFieldset('base_fieldset',
            array('legend' => Mage::helper('customshipping')->__('General Information'))
        );

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }

        $fieldset->addField('name', 'text', array(
            'name' => 'name',
            'label' => Mage::helper('customshipping')->__('Rule Name'),
            'title' => Mage::helper('customshipping')->__('Rule Name'),
            'required' => true,
        ));
	
	$fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('customshipping')->__('Status'),
            'title'     => Mage::helper('customshipping')->__('Status'),
            'name'      => 'is_active',
            'required' => true,
            'options'    => array(
                '1' => Mage::helper('customshipping')->__('Active'),
                '0' => Mage::helper('customshipping')->__('Inactive'),
            ),
        ));
	
	$fieldset->addField('priority', 'select', array(
	    'label' => Mage::helper('customshipping')->__('Priority'),
	    'title' => Mage::helper('customshipping')->__('Priority'),
            'values' => array('0'=>'Please Select..', '1' => '1', '2' => '2', '3' => '3'),
	    'name'  => 'priority',
	    'class' => 'validate-number',
	));
	
	$fieldset->addField('stop_other', 'select', array(
            'label'     => Mage::helper('customshipping')->__('Stop processing of further rules'),
            'title'     => Mage::helper('customshipping')->__('Stop processing of further rules'),
            'name'      => 'stop_other',
            'options'    => array(
                '1' => Mage::helper('customshipping')->__('Yes'),
                '0' => Mage::helper('customshipping')->__('No'),
            ),
	    'note'  => Mage::helper('customshipping')->__('Rules with higher number in priority field will not be processed if set to \'Yes\''),
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
	
        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }
	
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
