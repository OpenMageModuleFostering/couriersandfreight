<?php

class Candf_Customshipping_cnfcartController extends Mage_Core_Controller_Front_Action
{

    public function _construct() {
        parent::_construct();
        $this->loadLayout();
        $this->renderLayout();
    }


    public function autocompletecartAction() {
        $query = $this->getRequest()->getParam('query');
        echo $this->_makeAutocomplete($query);
        exit;
    }

    public function popupAction() {
            $post = $this->getRequest()->getPost();
            $popaction = $post['popup-option'];
            echo $popaction;
            die;

    }



    public function getAdditionalServiceListAction() {
        $getData = $this->getRequest()->getParam('CarrierId');

        $collection = Mage::getModel('customshipping/additionalservices')->getCollection();
        $getAdditionalServiceData= $collection->addFieldToFilter('Carrier_Id', array('in' =>array('in' => array($getData))))->getData();
        ?>
        <div class="backend-available-additional-servicess">
            <div><p><b>Extra Delivery Options</b></p></div>
                <ul>
                    <?php
                    foreach($getAdditionalServiceData as $getAdditional) {
                        ?>
                        <li>
                            <input name="additional-services" type="checkbox" value="<?php echo $getAdditional['id'];?>" id="<?php echo $getAdditional['Code'];?>"  checked="checked" class="backend-additional"/>
                            <label for="s_method_"><?php echo $getAdditional['Carrier_Service_Description'].'-  $'.$getAdditional['Carrier_Basic_Charge'];?></label>
                        </li>
                    <?php
                    }

                    ?>
                </ul>
        </div>
        <?php
        die;
    }

    public function getAdditionalservicesAction() {

        $getData = $this->getRequest()->getParam('id');
        $getCarrier= explode(" ", $getData);
        $Carrier_Name = $getCarrier['0'];
        $collection = Mage::getModel('customshipping/additionalservices')->getCollection();
        $getAdditionalServiceData= $collection->addFieldToFilter('Code', array('in' =>array('in' => array($Carrier_Name))))->getData();
        ?>
        <div><p><b>Extra Delivery Options</b></p></div>
        <ul>
            <?php
            foreach($getAdditionalServiceData as $getAdditional) {
                ?>
                <li>
                    <input name="additional-services[<?php echo $getAdditional['id']?>]" type="checkbox" value="<?php echo $getAdditional['id'];?>" id="<?php echo $getAdditional['Code'];?>"   class="radio"/>
                    <label for="s_method_"><?php echo $getAdditional['Carrier_Service_Description'].'-  $'.$getAdditional['Carrier_Basic_Charge'];?></label>
                </li>
            <?php
            }
            ?>
        </ul>
        <?php
        die;
    }

    protected function _makeAutocomplete($query)
    {
        $this->_result['query'] = $query;
        $query = preg_replace('/[^a-zA-Z0-9 ]/', ' ', $query);
        $query = trim(preg_replace('/  */', ' ', $query));
        $postcodes = explode(' ', $query);
        if (count($postcodes)) {
            $collection = Mage::getModel('customshipping/postcode')->getCollection();
            foreach ($postcodes as $postcode) {
                $collection->addFieldToFilter('main_table.fulltext', array('like' => '% ' . $postcode . '%'));
            }
            $i = -1;
            if (count($collection) > 0) {
                $this->_result['data'] = array();
                foreach ($collection as $item) {
                    $value = $item->getFulltext();
                    if (!in_array($value, $this->_result['suggestions'])) {
                        $i++;
                        $this->_result['suggestions'][$i] = $value;
                        $this->_result['data'][$i][] = $item->getData();
                    } else {
                        $this->_result['data'][$i][] = $item->getData();
                    }
                }
            }
        }

        $core_helper = Mage::helper('core');
        if (method_exists($core_helper, "jsonEncode")) {
            $result = Mage::helper('core')->jsonEncode($this->_result);
        } else {
            $result = Zend_Json::encode($this->_result);
        }
        return $result;
    }
}