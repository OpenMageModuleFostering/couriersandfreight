

<?php

class Candf_Customshipping_Block_Adminhtml_Rule_Edit_Tab_Actions
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
        return Mage::helper('customshipping')->__('Actions');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('customshipping')->__('Actions');
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

        $fieldset = $form->addFieldset('actions_fieldset', array(
            'legend'=>Mage::helper('customshipping')->__('Actions Configuration')
        ));

        $fieldset->addField('action_rate_type', 'select', array(
            'label'     => Mage::helper('customshipping')->__('Shipping Rate Type'),
            'title'     => Mage::helper('customshipping')->__('Shipping Rate Type'),
            'name'      => 'action_rate_type',
            'required' => true,
            'options'    => Mage::getModel('customshipping/system_config_backend_rule_type')->toOptionArray(),
            'onchange' => 'checkShippingRateType(this.value)'
        ));

        $fieldset = $form->addFieldset('actions_static_fieldset', array(
            'legend' => Mage::helper('customshipping')->__('Static Rate Configuration')
        ));

        $fieldset->addField('action_static_value', 'text', array(
            'label' => Mage::helper('customshipping')->__('Static Rate Value'),
            'title' => Mage::helper('customshipping')->__('Static Rate Value'),
            'name' => 'action_static_value',
            'class' => 'validate-number',
            'note' => 'Applies to free shipping and flat rate.'
        ));

        $fieldset->addField('action_static_label', 'text', array(
            'label' => Mage::helper('customshipping')->__('Static Rate Label'),
            'title' => Mage::helper('customshipping')->__('Static Rate Label'),
            'name' => 'action_static_label',
            'note' => Mage::helper('customshipping')->__('As displayed to a customer. Applies to free shipping & flat rate.')

        ));

        $fieldset->addField('action_hidden_link', 'hidden', array(
            'name' => 'action_hidden_link',
        ));

        $fieldset = $form->addFieldset('actions_dynamic_fieldset', array(
            'legend' => Mage::helper('customshipping')->__('Dynamic Carriers Configuration')
        ));

        $fieldset->addField('action_prefered_carrie_type', 'select', array(
            'name'  => 'action_prefered_carrie_type',
            'onchange' => 'checkSelectedItem(this.value)',
            'label' => Mage::helper('customshipping')->__('Select Carrier Type'),
            'title' => Mage::helper('customshipping')->__('Select Carrier Type'),
            'options' => Mage::getSingleton('customshipping/system_config_backend_rule_action_carrier')->toOptionArray(),
        ));

        $fieldset->addField('action_dynamic_carriers', 'multiselect', array(
            'name'     => 'action_dynamic_carriers[]',
            'label'     => Mage::helper('customshipping')->__('Carriers'),
            'title'     => Mage::helper('customshipping')->__('Carriers'),
            'values'   => Mage::getSingleton('customshipping/carrier_dynamic')->getCarrierList(true),
            'note' => Mage::helper('customshipping')->__('Use CTRL + click to select multiple carriers - To show in the Shipment options.'),
        ));

        $fieldset->addField('action_dynamic_filter', 'select', array(
            'name'  => 'action_dynamic_filter',
            'label' => Mage::helper('customshipping')->__('Display Filter'),
            'title' => Mage::helper('customshipping')->__('Display Filter'),
            'options' => Mage::getSingleton('customshipping/system_config_backend_rule_action_filter')->toOptionArray(),
        ));

        $fieldset = $form->addFieldset('actions_restrict_fieldset', array(
            'legend' => Mage::helper('customshipping')->__('Restrict Shipping Configuration')
        ));
        $fieldset->addField('action_restrict_note', 'textarea', array(
            'name'   => 'action_restrict_note',
            'label'  => Mage::helper('customshipping')->__('Note'),
            'title'  => Mage::helper('customshipping')->__('Note'),
            'note'   => Mage::helper('customshipping')->__('Displayed to a customer when shipping is restricted.')
        ));
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}

