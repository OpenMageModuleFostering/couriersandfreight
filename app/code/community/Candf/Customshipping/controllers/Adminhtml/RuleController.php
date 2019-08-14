<?php

class Candf_Customshipping_Adminhtml_RuleController extends Mage_Adminhtml_Controller_Action {

    const MODE_DEACTIVATE = 0;
    const MODE_ACTIVATE = 1;
    const MODE_DELETE = 2;


    protected $_allowedModes = array(
        self::MODE_DEACTIVATE => 'deactivated',
        self::MODE_ACTIVATE => 'activated',
        self::MODE_DELETE => 'deleted',
    );


    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('rule/item')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Rules'), Mage::helper('adminhtml')->__('Manage Rules'))
            ->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {
        $ruleId     = $this->getRequest()->getParam('id');
        $RuleModel  = Mage::getModel('customshipping/rule')->load($ruleId);

        if ($RuleModel->getId() || $ruleId == 0) {

            Mage::register('rule_data', $RuleModel);

            $this->loadLayout();
            $this->_setActiveMenu('customshipping/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Rule Manager'), Mage::helper('adminhtml')->__('Rule Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Rule News'), Mage::helper('adminhtml')->__('Rule News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('customshipping/adminhtml_rule_edit'))
                ->_addLeft($this->getLayout()->createBlock('customshipping/adminhtml_rule_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customshipping')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }

    }


    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('customshipping/rule');
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }

            //convert arrays to string
            foreach($data as $key => $val) {
                if(is_array($val)) {
                    $data[$key] = implode(',', $val);
                }
            }

            $model->setData($data);

            Mage::getSingleton('adminhtml/session')->setFormData($data);
            try {
                if ($id) {
                    $model->setId($id);
                }
                $model->save();

                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('customshipping')->__('Error saving rule'));
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('customshipping')->__('Rule was successfully saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // The following line decides if it is a "save" or "save and continue"
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/');
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                if ($model && $model->getId()) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/');
                }
            }
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customshipping')->__('No data found to save'));
        $this->_redirect('*/*/');
    }


    public function massDeactivateAction() {
        return $this->massStatusAction(self::MODE_DEACTIVATE);
    }

    public function massActivateAction() {
        return $this->massStatusAction(self::MODE_ACTIVATE);
    }

    public function massRemoveAction() {
        return $this->massStatusAction(self::MODE_DELETE);
    }


    protected function massStatusAction($mode = 0)
    {
        if(!array_key_exists($mode, $this->_allowedModes)) {
            $this->_getSession()->addError('Invalid mode specified for mass status action.');
            $this->_redirect('*/*');
            return;
        }

        $params = $this->getRequest()->getParams();


        if (!isset($params['massaction']) || !is_array($params['massaction']) || empty($params['massaction'])) {
            $this->_getSession()->addError(Mage::helper('customshipping')->__('No rules selected.'));
            $this->_redirect('*/*/');
        }

        $rule_ids = $params['massaction'];
        $notices = array();

        $count = 0;
        foreach ($rule_ids as $id) {
            $rule = Mage::getModel('customshipping/rule')->load($id);

            if (!$rule || !$rule->getId()) {
                $notices[] = "Rule ID $id not found.";
                continue;
            }

            switch($mode) {
                case self::MODE_DELETE:
                    $rule->delete(); break;
                case self::MODE_ACTIVATE:
                case self::MODE_DEACTIVATE:
                    $rule->setIsActive($mode);
                    $rule->save();
                    break;
            }

            $count++;
        }

        if (!empty($notices)) {
            foreach ($notices as $notice)
                $this->_getSession()->addError($notice);
        }

        $successMsg = $this->_allowedModes[$mode];
        $this->_getSession()->addSuccess("Total of $count rules $successMsg.");


        $this->_redirect('*/*/');

        return;
    }





}
