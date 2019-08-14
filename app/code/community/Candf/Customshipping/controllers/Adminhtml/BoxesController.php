<?php

class Candf_Customshipping_Adminhtml_BoxesController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('boxes/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Boxes Manager'), Mage::helper('adminhtml')->__('Boxes Manager'));
        return $this;
    }

    public function indexAction() {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('customshipping/adminhtml_boxes'));
        $this->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $boxesId     = $this->getRequest()->getParam('id');
        $boxesModel  = Mage::getModel('customshipping/boxes')->load($boxesId);

        if ($boxesModel->getId() || $boxesId == 0) {

            Mage::register('boxes_data', $boxesModel);

            $this->loadLayout();
            $this->_setActiveMenu('customshipping/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Boxes Manager'), Mage::helper('adminhtml')->__('Boxes Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Boxes News'), Mage::helper('adminhtml')->__('Boxes News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('customshipping/adminhtml_boxes_edit'))
                ->_addLeft($this->getLayout()->createBlock('customshipping/adminhtml_boxes_edit_tabs'));

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
                $warehouseModel = Mage::getModel('customshipping/boxes');

                $warehouseModel->setId($this->getRequest()->getParam('id'))
                    ->setName($postData['name'])
                    ->setIsActive($postData['is_active'])
                    ->setLength($postData['length'])
                    ->setWidth($postData['width'])
                    ->setHeight($postData['height'])
                    ->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setBoxesData(false);

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setBoxesData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }


}