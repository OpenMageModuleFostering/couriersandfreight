<?php
class Candf_Customshipping_Block_Adminhtml_Warehouse_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('warehouseGrid');
        // This is the primary key of the database
        $this->setDefaultSort('warehouse_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('customshipping/warehouse')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('warehouse_id', array(
            'header' => Mage::helper('customshipping')->__('Warehouse Id'),
            'width' => '100px',
            'index' => 'warehouse_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('customshipping')->__('Name'),
            'width' => '160px',
            'index' => 'name',
        ));

        $this->addColumn('is_active', array(
            'header' => Mage::helper('customshipping')->__('Status'),
            'width' => '160px',
            'index' => 'is_active',
        ));


        $this->addColumn('zip', array(
            'header' => Mage::helper('customshipping')->__('Zip/Post Code'),
            'align' => 'left',
            'index' => 'zip',
        ));


        $this->addColumn('suburb', array(
            'header' => Mage::helper('customshipping')->__('Suburb'),
            'align' => 'left',
            'index' => 'suburb',
        ));
        $this->addColumn('state', array(
            'header' => Mage::helper('customshipping')->__('State'),
            'align' => 'left',
            'index' => 'state',
        ));

        $this->addColumn('country', array(
            'header' => Mage::helper('customshipping')->__('Country'),
            'align' => 'left',
            'index' => 'country',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
