<?php

class Candf_Customshipping_Adminhtml_ZoneController extends Mage_Adminhtml_Controller_Action
{
    
    protected function _initAction()
	{
		$this->loadLayout()
			->_setActiveMenu('zone/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Zone Manager'), Mage::helper('adminhtml')->__('Zone Manager'));
		return $this;
	}   
   
	public function indexAction() {
		$this->_initAction();
		$this->_addContent($this->getLayout()->createBlock('customshipping/adminhtml_zone'));
		$this->renderLayout();
	}

	public function editAction()
	{
		$warehouseId     = $this->getRequest()->getParam('id');
		$warehouseModel  = Mage::getModel('customshipping/zone')->load($warehouseId);
 
		if ($warehouseModel->getId() || $warehouseId == 0) {
 
			Mage::register('zone_data', $warehouseModel);
 
			$this->loadLayout();
			$this->_setActiveMenu('customshipping/items');
		   
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Zone Manager'), Mage::helper('adminhtml')->__('Zone Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Zone News'), Mage::helper('adminhtml')->__('Zone News'));
		   
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		   
			$this->_addContent($this->getLayout()->createBlock('customshipping/adminhtml_zone_edit'))
				 ->_addLeft($this->getLayout()->createBlock('customshipping/adminhtml_zone_edit_tabs'));
			   
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customshipping')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction()
	{
		$this->_forward('edit');
	}
   
	public function saveAction()
	{
		if ( $this->getRequest()->getPost() ) {
			try {
				$postData = $this->getRequest()->getPost();
				$warehouseModel = Mage::getModel('customshipping/zone');
			   
				$warehouseModel->setId($this->getRequest()->getParam('id'))
					->setStateName($postData['name'])
					->setStoreName($postData['name'])
					->save();
			   
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setWarehouseData(false);
 
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setWarehouseData($this->getRequest()->getPost());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		$this->_redirect('*/*/');
	}
   
	public function deleteAction()
	{
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$warehouseModel = Mage::getModel('customshipping/zone');
			   
				$warehouseModel->setId($this->getRequest()->getParam('id'))
					->delete();
				   
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
	/**
	 * Product grid for AJAX request.
	 * Sort and filter result for example.
	 */
	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
			   $this->getLayout()->createBlock('importedit/adminhtml_zone_grid')->toHtml()
		);
	}
    
}
