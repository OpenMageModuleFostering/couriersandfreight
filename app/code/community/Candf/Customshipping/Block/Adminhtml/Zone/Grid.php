<?php
 class Candf_Customshipping_Block_Adminhtml_Zone_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('zoneGrid');
		// This is the primary key of the database
		$this->setDefaultSort('zone_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('customshipping/zone')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }


    protected function _prepareColumns()
    {

        $this->addColumn('zone_id', array(
            'header' => Mage::helper('customshipping')->__('Zone Id'),
        	'width' => '160px',
            'index' => 'zone_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('customshipping')->__('Name'),
        	'width' => '160px',
            'index' => 'name',
        ));
        
        $this->addColumn('country', array(
            'header' => Mage::helper('customshipping')->__('Country'),
        	'width' => '160px',
            'index' => 'country',
        ));
        
        $this->addColumn('range', array(
            'header' => Mage::helper('customshipping')->__('Postal Code Ranges'),
            'align' => 'left',
			'width' => '160px',
            'index' => 'range',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
