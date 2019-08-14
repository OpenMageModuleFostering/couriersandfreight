<?php

class Candf_Customshipping_Block_Adminhtml_Shipment_grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('customshipping/shipment')->getCollection();
        $collection->join('sales/order', 'main_table.order_id=`sales/order`.entity_id', array('increment_id', 'created_at', 'shipping_amount','shipping_method'));
        $collection->addFieldToFilter('shipping_method',array('like' => '%candf%'));

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('order_number', array(
            'header' => Mage::helper('customshipping')->__('Order #'),
            'width' => '100px',
            'index' => 'increment_id',
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('customshipping')->__('Purchased On'),
            'width' => '160px',
            'type' => 'datetime',
            'index' => 'created_at',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('customshipping')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '100px',
            'filter_index' => 'main_table.status',
            'options' => Mage::getSingleton('customshipping/system_config_backend_shipment_status')->getOptions(),
        ));

        $this->addColumn('shipping_paid', array(
            'header' => Mage::helper('customshipping')->__('Shipping Paid'),
            'align' => 'left',
            'type'  => 'currency',
            'currency_code' => Mage::app()->getStore()->getCurrentCurrencyCode(),
            'index' => 'shipping_amount',
        ));

        $this->addColumn('selected_quote_description', array(
            'header' => Mage::helper('customshipping')->__('Selected Quote'),
            'align' => 'left',
            'index' => 'customer_selected_quote_description',
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('customshipping')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                'view' => array(
                    'caption' => Mage::helper('customshipping')->__('View'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }


}