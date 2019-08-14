<?php

class Carriers{
    public $customerId;
    public $serviceTypeName;
}

class Candf_Customshipping_Model_Carrier_Dynamic
{
    /* Get All the Carrier list */

    public function getCarrierList($enabledOnly = false, $type) {
        $candconfig = Mage::getStoreConfig('candf');
        $apikey = $candconfig['general']['api'];
        $password = $candconfig['general']['password'];


        if ($candconfig['general']['active'] == 1) {

            $auth = array('AuthKey' => $apikey, 'Password' => $password);

            if($candconfig['general']['sandbox']=='1') {
                $centinelClient = new SoapClient('https://live.couriersandfreight.com.au/CandFAPITest/Service.svc?wsdl', array("soap_version" => SOAP_1_1, "trace" => 1, 'exceptions' => true));
                $header = new SoapHeader("https://live.couriersandfreight.com.au/CandFAPITest/Service.svc?wsdl", "APIKey", $auth, false);
            }else {
                $centinelClient = new SoapClient('https://live.couriersandfreight.com.au/CandFAPILive/Service.svc?wsdl', array("soap_version" => SOAP_1_1, "trace" => 1, 'exceptions' => true));
                $header = new SoapHeader("https://live.couriersandfreight.com.au/CandFAPILive/Service.svc?wsdl", "APIKey", $auth, false);

            }
            $centinelClient->__setSoapHeaders(array($header));

            $Carriers = new Carriers();
            $Carriers->customerId = $apikey;
            if(!empty($type))
            {
                $Carriers->serviceTypeName = $type;
            }
            else{
                $Carriers->serviceTypeName = 'All';
            }

            $curi = $centinelClient->GetCarrierByAPIkey($Carriers);
            $Carriers = array();
            $Carriers = $curi->GetCarrierByAPIkeyResult->CarrierList->Courier;

            foreach ($Carriers as $carrier) {
                $options[] = array(
                    'label' => $carrier->Name,
                    'value' => $carrier->ID
                );
            }
        }

        return $options;
    }
}
