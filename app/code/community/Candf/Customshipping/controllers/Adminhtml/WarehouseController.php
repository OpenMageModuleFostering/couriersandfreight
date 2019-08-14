<?php

class Candf_Customshipping_Adminhtml_WarehouseController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('warehouse/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Warehouse Manager'), Mage::helper('adminhtml')->__('Warehouse Manager'));
        return $this;
    }

    public function indexAction() {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('customshipping/adminhtml_warehouse'));
        $this->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $warehouseId     = $this->getRequest()->getParam('id');
        $warehouseModel  = Mage::getModel('customshipping/warehouse')->load($warehouseId);

        if ($warehouseModel->getId() || $warehouseId == 0) {

            Mage::register('warehouse_data', $warehouseModel);

            $this->loadLayout();
            $this->_setActiveMenu('customshipping/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Warehouse Manager'), Mage::helper('adminhtml')->__('Warehouse Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Warehouse News'), Mage::helper('adminhtml')->__('Warehouse News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('customshipping/adminhtml_warehouse_edit'))
                ->_addLeft($this->getLayout()->createBlock('customshipping/adminhtml_warehouse_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customshipping')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                $warehouseModel = Mage::getModel('customshipping/warehouse');

                $warehouseModel->setId($this->getRequest()->getParam('id'))
                    ->setName($postData['name'])
                    ->setIsActive($postData['is_active'])
                    ->setCompanyName($postData['company_name'])
                    ->setLine1($postData['street_add1'])
                    ->setLine2($postData['street_add2'])
                    ->setZip($postData['zip'])
                    ->setSuburb($postData['suburb'])
                    ->setState($postData['state'])
                    ->setCountry($postData['country'])
                    ->setContactName($postData['contact_name'])
                    ->setContactEmail($postData['contact_email'])
                    ->setPhone1($postData['phone1'])
                    ->setPhone2($postData['phone2'])
                    ->setFax($postData['fax'])
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


}