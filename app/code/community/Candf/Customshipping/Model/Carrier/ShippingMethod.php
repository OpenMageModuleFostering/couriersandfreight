<?php

ini_set('soap.wsdl_cache_enabled', 0);
ini_set('soap.wsdl_cache_ttl', 0);

class PickUpAddress {

    public $CountryCode;
    public $Suburb;
    public $PostCode;

}

class DeliveryAddress {

    public $CountryCode;
    public $Suburb;
    public $PostCode;

}

class CFParam_Rate {

    public $key;
    public $rateRequest;

}
class Test1{
    public $customerId;
    public $serviceTypeName;
}

class Parcel {

    public $Height;
    public $Length;
    public $Width;
    public $Weight;

}

class APIKey {

    public $AuthKey;
    public $Password;

}

class RateRequest {

    public $PickUpAddress;
    public $DeliveryAddress;
    public $Parcel;

}

class Candf_Customshipping_Model_Carrier_ShippingMethod extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface {

    protected $_code = 'candf_customshipping';
    protected $_isFixed = true;

    public function getAllowedMethods() {
        return array('candf-customshipping' => 'cheapest');
    }

    public function collectRates(Mage_Shipping_Model_Rate_Request $request) {
        if(isset($_REQUEST['cart-popup-no'])) {
            $checkout_without_cnf = $_REQUEST['cart-popup-no'];
        }
        if(empty($checkout_without_cnf)) {
               // $con = Mage::getSingleton('core/resource')->getConnection('core_write');
                $candconfig = Mage::getStoreConfig('candf');

                // START RULE ENGINE
                if($candconfig['rule']['rulestatus'] == 1)
                {
                    $rules = Mage::getModel('customshipping/rule')->getCollection()
                        ->addFieldToFilter('is_active', '1')
                        ->getData();

                    foreach($rules as $rule)
                    {
                        if($rule['stop_other'] == 1)
                        {
                            if($rule['action_rate_type'] == 4 )
                            {
                                $error = Mage::getModel('shipping/rate_result_error');
                                $error->setCarrier('candf_customshipping');
                                $error->setCarrierTitle('CandF Shipping');
                                $error->setErrorMessage($rule['action_restrict_note']);
                                $result = $error;
                                return $result;
                            }
                            else if($rule['action_rate_type'] == 2)
                            {
                                $lable = $rule['action_static_label'];
                                $price = $rule['action_static_value'];
                                if($price  != 0)
                                {
                                    $price = "0.00";
                                }
                                $method = Mage::getModel('shipping/rate_result_method');
                                $method->setCarrier('candf_customshipping');
                                $method->setCarrierTitle('CandF Shipping');
                                $method->setMethod("Free Shipping");
                                $method->setMethodTitle('Free Shipping Method');
                                $method->setPrice($price);
                                $method->setCost($price);
                                $result = ($method);
                                return $result;
                            }
                            else if($rule['action_rate_type'] == 1)
                            {
                                $lable = $rule['action_static_label'];
                                $price = $rule['action_static_value'];
                                $method = Mage::getModel('shipping/rate_result_method');
                                $method->setCarrier('candf_customshipping');
                                $method->setCarrierTitle('CandF Shipping');
                                $method->setMethod("Flat Rate Shipping");
                                $method->setMethodTitle($lable);
                                $method->setPrice($price);
                                $method->setCost($price);
                                $result = ($method);
                                return $result;
                            }
                            else if($rule['action_rate_type'] == 3)
                            {
                                $CarrierIds = $rule['action_dynamic_carriers'];
                                $arrayCarrierIds = explode(",", $CarrierIds);
                                $DynamicActive = true;
                            }
                        }
                        else if($rule['priority'] == 1)
                        {
                            if($rule['action_rate_type'] == 4 )
                            {
                                $error = Mage::getModel('shipping/rate_result_error');
                                $error->setCarrier('candf_customshipping');
                                $error->setCarrierTitle('CandF Shipping');
                                $error->setErrorMessage($rule['action_restrict_note']);
                                $result = $error;
                                return $result;
                            }
                            else if($rule['action_rate_type'] == 2)
                            {
                                $lable = $rule['action_static_label'];
                                $price = $rule['action_static_value'];
                                if($price  != 0)
                                {
                                    $price = "0.00";
                                }
                                $method = Mage::getModel('shipping/rate_result_method');
                                $method->setCarrier('candf_customshipping');
                                $method->setCarrierTitle('CandF Shipping');
                                $method->setMethod("Free Shipping");
                                $method->setMethodTitle('Free Shipping Method');
                                $method->setPrice($price);
                                $method->setCost($price);
                                $result = ($method);
                                return $result;
                            }
                            else if($rule['action_rate_type'] == 1)
                            {
                                $lable = $rule['action_static_label'];
                                $price = $rule['action_static_value'];
                                $method = Mage::getModel('shipping/rate_result_method');
                                $method->setCarrier('candf_customshipping');
                                $method->setCarrierTitle('CandF Shipping');
                                $method->setMethod("Flat Rate Shipping");
                                $method->setMethodTitle($lable);
                                $method->setPrice($price);
                                $method->setCost($price);
                                $result = ($method);
                                return $result;
                            }
                            else if($rule['action_rate_type'] == 3)
                            {
                                $CarrierIds = $rule['action_dynamic_carriers'];
                                $arrayCarrierIds = explode(",", $CarrierIds);
                                $DynamicActive = true;
                            }
                        }
                        else if($rule['priority'] == 2)
                        {
                            if($rule['action_rate_type'] == 4 )
                            {
                                $error = Mage::getModel('shipping/rate_result_error');
                                $error->setCarrier('candf_customshipping');
                                $error->setCarrierTitle('CandF Shipping');
                                $error->setErrorMessage($rule['action_restrict_note']);
                                $result = $error;
                                return $result;
                            }
                            else if($rule['action_rate_type'] == 2)
                            {
                                $lable = $rule['action_static_label'];
                                $price = $rule['action_static_value'];
                                if($price  != 0)
                                {
                                    $price = "0.00";
                                }
                                $method = Mage::getModel('shipping/rate_result_method');
                                $method->setCarrier('candf_customshipping');
                                $method->setCarrierTitle('CandF Shipping');
                                $method->setMethod("Free Shipping");
                                $method->setMethodTitle('Free Shipping Method');
                                $method->setPrice($price);
                                $method->setCost($price);
                                $result = ($method);
                                return $result;
                            }
                            else if($rule['action_rate_type'] == 1)
                            {
                                $lable = $rule['action_static_label'];
                                $price = $rule['action_static_value'];
                                $method = Mage::getModel('shipping/rate_result_method');
                                $method->setCarrier('candf_customshipping');
                                $method->setCarrierTitle('CandF Shipping');
                                $method->setMethod("Flat Rate Shipping");
                                $method->setMethodTitle($lable);
                                $method->setPrice($price);
                                $method->setCost($price);
                                $result = ($method);
                                return $result;
                            }
                            else if($rule['action_rate_type'] == 3)
                            {
                                $CarrierIds = $rule['action_dynamic_carriers'];
                                $arrayCarrierIds = explode(",", $CarrierIds);
                                $DynamicActive = true;
                            }
                        }
                        else if($rule['priority'] == 3)
                        {
                            if($rule['action_rate_type'] == 4 )
                            {
                                $error = Mage::getModel('shipping/rate_result_error');
                                $error->setCarrier('candf_customshipping');
                                $error->setCarrierTitle('CandF Shipping');
                                $error->setErrorMessage($rule['action_restrict_note']);
                                $result = $error;
                                return $result;
                            }
                            else if($rule['action_rate_type'] == 2)
                            {
                                $lable = $rule['action_static_label'];
                                $price = $rule['action_static_value'];
                                if($price  != 0)
                                {
                                    $price = "0.00";
                                }
                                $method = Mage::getModel('shipping/rate_result_method');
                                $method->setCarrier('candf_customshipping');
                                $method->setCarrierTitle('CandF Shipping');
                                $method->setMethod("Free Shipping");
                                $method->setMethodTitle('Free Shipping Method');
                                $method->setPrice($price);
                                $method->setCost($price);
                                $result = ($method);
                                return $result;
                            }
                            else if($rule['action_rate_type'] == 1)
                            {
                                $lable = $rule['action_static_label'];
                                $price = $rule['action_static_value'];
                                $method = Mage::getModel('shipping/rate_result_method');
                                $method->setCarrier('candf_customshipping');
                                $method->setCarrierTitle('CandF Shipping');
                                $method->setMethod("Flat Rate Shipping");
                                $method->setMethodTitle($lable);
                                $method->setPrice($price);
                                $method->setCost($price);
                                $result = ($method);
                                return $result;
                            }
                            else if($rule['action_rate_type'] == 3)
                            {
                                $CarrierIds = $rule['action_dynamic_carriers'];
                                $arrayCarrierIds = explode(",", $CarrierIds);
                                $DynamicActive = true;
                            }
                        }
                    }
                }
                // END RULE ENGINE

                $apikey = $candconfig['general']['api'];
                $password = $candconfig['general']['password'];
                if ($candconfig['general']['active'] == 1) {
                    if ($candconfig['countries']['specificcountry'] == 'AU') {
                        $cart = Mage::getSingleton('checkout/cart')->getQuote();
                        $shippingaddress = $cart->getShippingAddress();
                        if ($shippingaddress['country_id'] == 'AU') {
                            $k = 0;
                            $k2 = 0;

                            $rateRequest = new RateRequest();

                            $pickupaddress = new PickUpAddress();
                            $pickupaddress->CountryCode = 'AUS';
                            $pickupaddress->PostCode = $candconfig['warehouse']['warehouse_code'];
                            $pickupaddress->Suburb = $candconfig['warehouse']['warehouse_suburb'];
                            $rateRequest->PickUpAddress = $pickupaddress;

                            $deliveryaddress = new DeliveryAddress();
                            $deliveryaddress->CountryCode = 'AUS';
                            $deliveryaddress->PostCode = $shippingaddress['postcode'];
                            $deliveryaddress->Suburb = $shippingaddress['city'];
                            $rateRequest->DeliveryAddress = $deliveryaddress;

                            $key = new APIKey();
                            $key->AuthKey = $apikey;
                            $key->Password = $password;

                            // $configsetting = $candconfig = Mage::helper('customshipping/customshipping')->loadConfig();

                            $cart = Mage::getModel('checkout/cart')->getQuote();

                            foreach ($cart->getAllItems() as $pitem) {
                                if ($pitem->getProductType != 'virtual') {
                                    $productid = $pitem->getProductId();
                                    $qty = $pitem->getQty();
                                    $_product = Mage::getSingleton('catalog/product')->load($productid);
                                    $length = $_product->getResource()->getAttribute('candf_length')->getFrontend()->getValue($_product);
                                    $height = $_product->getResource()->getAttribute('candf_height')->getFrontend()->getValue($_product);
                                    $width = $_product->getResource()->getAttribute('candf_width')->getFrontend()->getValue($_product);
                                    $weight = $_product->getResource()->getAttribute('weight')->getFrontend()->getValue($_product);

                                    $proLenght = $length;
                                    $proHeight =$height;
                                    $proWidth = $width;
                                    $proWeight = $weight;
                                    $proQty = $qty;


                                    $meterRate = $_product->getResource()->getAttribute('candf_meter_rate')->getFrontend()->getValue($_product);
                                    $packagedLength  = $_product->getResource()->getAttribute('candf_packaged_length')->getFrontend()->getValue($_product);

                                    if(($length=='') or ($length =="0" )) {
                                        $length = $candconfig['packaging']['length'];
                                    }
                                    if(($height == '') or ($height == "0")) {
                                        $height = $candconfig['packaging']['height'];
                                    }
                                    if(($width == '') or ($width == "0")) {
                                        $width = $candconfig['packaging']['width'];
                                    }

                                    if($meterRate && (bool)$packagedLength) {
                                        $floatLength = floatval($packagedLength);
                                        $packageWeight = ($floatLength*$weight)/$length;
                                        $how_many_parts_make_up_one_product = $floatLength /floatval($length);
                                        $length = $floatLength;
                                        $packageQty = $qty/$how_many_parts_make_up_one_product;
                                        $qty = floor($packageQty);
                                        $decimalVal = $packageQty - $qty;

                                        //calculate simple product

                                        $additionalQty = round(($packagedLength * $decimalVal)/$proLenght);
                                        $weight = $packageWeight;
                                        if($packageQty < 1) {
                                            $length =$proLenght;
                                            $height = $proHeight;
                                            $width = $proWidth;
                                            $weight = $proWeight;
                                            $qty = $proQty;

                                        }
                                    }


                                    for ($c = 1; $c <= $qty; $c++) {
                                        $parcel[$k] = new Parcel();
                                        $parcel[$k]->Height = $height;
                                        $parcel[$k]->Length = $length;
                                        $parcel[$k]->Width = $width;
                                        $parcel[$k]->Weight = $weight;
                                        $k++;
                                    }

                                    if(!empty($additionalQty)) {
                                        for ($c = 1; $c <= $additionalQty; $c++) {
                                            $aditional_parcel[$k2] = new Parcel();
                                            $aditional_parcel[$k2]->Height = $proHeight;
                                            $aditional_parcel[$k2]->Length = $proLenght;
                                            $aditional_parcel[$k2]->Width = $proWidth;
                                            $aditional_parcel[$k2]->Weight = $proWeight;
                                            $k2++;
                                        }
                                    }
                                }

                            }


                            if(!empty($aditional_parcel)) {
                                foreach($aditional_parcel as $aditional_parcelArr) {
                                    array_push($parcel,$aditional_parcelArr);
                                }

                            }

                            if (count($parcel) != 0)
                                $k = count($parcel);
                            $rateRequest->Parcel = $parcel;
                            $auth = array('AuthKey' => $candconfig['general']['api'], 'Password' => $candconfig['general']['password']);

                            if($candconfig['general']['sandbox']=='1') {
                                $centinelClient = new SoapClient('https://live.couriersandfreight.com.au/CandFAPITest/Service.svc?wsdl', array("soap_version" => SOAP_1_1, "trace" => 1, 'exceptions' => true));
                                $header = new SoapHeader("https://live.couriersandfreight.com.au/CandFAPITest/Service.svc?wsdl", "APIKey", $auth, false);


                            }else {
                                $centinelClient = new SoapClient('https://live.couriersandfreight.com.au/CandFAPILive/Service.svc?wsdl', array("soap_version" => SOAP_1_1, "trace" => 1, 'exceptions' => true));
                                $header = new SoapHeader("https://live.couriersandfreight.com.au/CandFAPILive/Service.svc?wsdl", "APIKey", $auth, false);
                            }

                            $centinelClient->__setSoapHeaders(array($header));
                            $ratePara = new CFParam_Rate();
                            $ratePara->key = $key;
                            $ratePara->rateRequest = $rateRequest;

                            $Carriers = new Test1();
                            $Carriers->customerId = $candconfig['general']['api'];
                            $Carriers->serviceTypeName = 'All';

                            $curi = $centinelClient->GetCarrierByAPIkey($Carriers);
                            $webservice = $centinelClient->Rate($ratePara);

                            $methodcount = $candconfig['markup']['shippingmethod_count'];
                            if ($webservice->RateResult->Status != "FAIL") {
                                $result = Mage::getModel('shipping/rate_result');
                                $resultCount = count($webservice->RateResult->RateCollection->Rate);
                                if ($methodcount > $resultCount) {
                                    $methodcount = $resultCount;
                                }
                                if(isset($DynamicActive) && $DynamicActive == true )
                                {
                                    for ($i = 0; $i < $methodcount; $i++) {
                                        $carrierId = $webservice->RateResult->RateCollection->Rate[$i]->CarrierId;
                                        if(false !== $key = array_search($carrierId, $arrayCarrierIds))
                                        {
                                            $requestprice = $webservice->RateResult->RateCollection->Rate[$i]->CurrencyValue;
                                            if ($candconfig['markup']['markup_type'] == 'rate') {
                                                $markup = $candconfig['markup']['markup_price'];
                                            } else if ($candconfig['markup']['markup_type'] == 'percentage') {
                                                $markuppercent = $candconfig['markup']['markup_price'];
                                                $markup = ($markuppercent / 100) * $requestprice;
                                            }
                                            if ($candconfig['handlingfee']['handlingfee_active'] == 1) {
                                                if ($candconfig['handlingfee']['handlingfee_type'] == 'rate') {
                                                    $handlingFee = $candconfig['handlingfee']['handlingfee_price'];
                                                } elseif ($candconfig['handlingfee']['handlingfee_type'] == 'percentage') {
                                                    $handlingFeePercent = $candconfig['handlingfee']['handlingfee_price'];
                                                    $handlingFee = ($handlingFeePercent / 100) * $requestprice;
                                                }
                                            } else {
                                                $handlingFee = 0.00;
                                            }

                                            $servicename = $webservice->RateResult->RateCollection->Rate[$i]->ServiceName;
                                            $carriertitle = $webservice->RateResult->RateCollection->Rate[$i]->CarrierName;
                                            $cutoff = $webservice->RateResult->RateCollection->Rate[$i]->Cutoff;
                                            $carrierid = $carriertitle . "_" . $servicename;
                                            $carriertitle .= " ( " . $servicename . " )";
                                            $price = $markup + $requestprice + $handlingFee;

                                            $method = Mage::getModel('shipping/rate_result_method');



                                            $method->setCarrier('candf_customshipping');
                                            $method->setCarrierTitle('');
                                            $method->setMethod($carrierid);
                                            $method->setMethodTitle($carriertitle);
                                            $method->setPrice($price);
                                            $method->setCost($price);
                                            $result->append($method);
                                        }
                                    }
                                }
                                else
                                {
                                    for ($i = 0; $i < $methodcount; $i++) {
                                        $requestprice = $webservice->RateResult->RateCollection->Rate[$i]->CurrencyValue;
                                        if ($candconfig['markup']['markup_type'] == 'rate') {
                                            $markup = $candconfig['markup']['markup_price'];
                                        } else if ($candconfig['markup']['markup_type'] == 'percentage') {
                                            $markuppercent = $candconfig['markup']['markup_price'];
                                            $markup = ($markuppercent / 100) * $requestprice;
                                        }
                                        if ($candconfig['handlingfee']['handlingfee_active'] == 1) {
                                            if ($candconfig['handlingfee']['handlingfee_type'] == 'rate') {
                                                $handlingFee = $candconfig['handlingfee']['handlingfee_price'];
                                            } elseif ($candconfig['handlingfee']['handlingfee_type'] == 'percentage') {
                                                $handlingFeePercent = $candconfig['handlingfee']['handlingfee_price'];
                                                $handlingFee = ($handlingFeePercent / 100) * $requestprice;
                                            }
                                        } else {
                                            $handlingFee = 0.00;
                                        }

                                        $servicename = $webservice->RateResult->RateCollection->Rate[$i]->ServiceName;
                                        $carriertitle = $webservice->RateResult->RateCollection->Rate[$i]->CarrierName;
                                        $cutoff = $webservice->RateResult->RateCollection->Rate[$i]->Cutoff;
                                        $carrierid = $carriertitle . "_" . $servicename;
                                        $carriertitle .= " ( " . $servicename . " )";
                                        $price = $markup + $requestprice + $handlingFee;

                                        $method = Mage::getModel('shipping/rate_result_method');


                                        $method->setCarrier('candf_customshipping');
                                        $method->setCarrierTitle('');
                                        $method->setMethod($carrierid);
                                        $method->setMethodTitle($carriertitle);
                                        $method->setPrice($price);
                                        $method->setCost($price);
                                        $result->append($method);
                                    }
                                }
                            } else {
                                $error = Mage::getModel('shipping/rate_result_error');
                                $error->setCarrier('candf_customshipping');
                                $error->setCarrierTitle('CandF Shipping');
                                $error->setErrorMessage('Shipping method not available');
                                $result = $error;
                            }
                            return $result;
                        }
                    }
                }

        }

    }

}
