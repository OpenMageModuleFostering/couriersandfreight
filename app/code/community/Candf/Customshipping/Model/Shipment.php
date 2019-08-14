<?php
class AccountValidationRequest{
    public $CustomerId;
    public $ShipmentCost;
}


class Candf_Customshipping_Model_Shipment extends Mage_Core_Model_Abstract
{
    public function _construct() {
        parent::_construct();
        $this->_init('customshipping/shipment');
    }

    /**
     * Gets the shipping amount the customer paid on this order.
     */
    public function getShippingPaid()
    {
        if ($this->getOrder()) {
            return $this->getOrder()->getShippingAmount();
        }
        return null;
    }

    function creditLimitExceeded($cost){
        $bVal = false;

        $candconfig = Mage::getStoreConfig('candf');
        $apikey = $candconfig['general']['api'];
        $password = $candconfig['general']['password'];

        $auth = array('AuthKey'=>$apikey,'Password'=>$password);



        if($candconfig['general']['sandbox']=='1') {
            $centinelClient = new SoapClient('https://live.couriersandfreight.com.au/CandFAPITest/Service.svc?wsdl',array("soap_version" => SOAP_1_1,"trace"=>1,'exceptions'=>true));
            $header = new SoapHeader("https://live.couriersandfreight.com.au/CandFAPITest/Service.svc?wsdl", "APIKey", $auth,false);
        }else {
            $centinelClient = new SoapClient('https://live.couriersandfreight.com.au/CandFAPILive/Service.svc?wsdl',array("soap_version" => SOAP_1_1,"trace"=>1,'exceptions'=>true));
            $header = new SoapHeader("https://live.couriersandfreight.com.au/CandFAPILive/Service.svc?wsdl", "APIKey", $auth,false);
        }


        $centinelClient->__setSoapHeaders(array($header));

        $av = new AccountValidationRequest();

        $av->CustomerId =$apikey;
        $av->ShipmentCost =$cost;

        $webservice = $centinelClient->AccountValidation(array('validationRequst' => $av));

        if($webservice->AccountValidationResult == ''){
            $bVal = true;
        }

        return $bVal;

    }


}