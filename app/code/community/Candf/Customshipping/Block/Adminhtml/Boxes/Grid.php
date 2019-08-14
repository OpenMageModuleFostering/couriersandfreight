<?php
class Candf_Customshipping_Block_Adminhtml_Boxes_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('boxesGrid');
        // This is the primary key of the database
        $this->setDefaultSort('boxes_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('customshipping/boxes')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('boxes_id', array(
            'header' => Mage::helper('customshipping')->__('Boxes Id'),
            'width' => '100px',
            'index' => 'boxes_id',
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


        $this->addColumn('length', array(
            'header' => Mage::helper('customshipping')->__('Length'),
            'align' => 'left',
            'index' => 'length',
        ));


        $this->addColumn('width', array(
            'header' => Mage::helper('customshipping')->__('Width'),
            'align' => 'left',
            'index' => 'width',
        ));
        $this->addColumn('height', array(
            'header' => Mage::helper('customshipping')->__('Height'),
            'align' => 'left',
            'index' => 'height',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
