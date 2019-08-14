<?php
ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
class PickUpAddresses
{
    public $CountryCode;
    public $Suburb;
    public $PostCode;
    public $CountryName;
}
class DeliveryAddresses
{
    public $CountryCode;
    public $Suburb;
    public $PostCode;
    public $CountryName;
}
class CFParam_Rate
{
    public $key;
    public $rateRequest;
}
class AddOnServiceChageList
{

}
class Parcel
{
    public $Height;
    public $Length;
    public $Width;
    public $Weight;
}
class APIKey
{
    public $AuthKey;
    public $Password;
}
class RateRequest
{
    public $PickUpAddress;
    public $DeliveryAddress;
    public $Parcel;
}

class Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Form_Quotes extends Candf_Customshipping_Block_Adminhtml_Shipment_Edit_Tab_Abstract
{
    public function getProductFromItem(Mage_Sales_Model_Order_Item $item)
    {
        return Mage::getModel('catalog/product')
            ->load($item->getProductId());
    }

    public function getSoaprequest()
    {
        $_shipment = $this->getShipment();
        $orderid = $_shipment->getOrderId();
        $order = Mage::getModel('sales/order')->load($orderid);
        $customshipping2 = Mage::getModel('customshipping/shipment')->load($this->getShipment()->getId());
        $incrementid = $order->getIncrementId();
        $candconfig = Mage::getStoreConfig('candf');
        $apikey = $candconfig['general']['api'];
        $password = $candconfig['general']['password'];

        if($candconfig['general']['active'] == 1)
        {
            if($candconfig['countries']['specificcountry'] == 'AU')
            {
                $cart = Mage::getSingleton('checkout/cart')->getQuote();
                $shippingaddress = $cart->getShippingAddress();
                $k = 0;
                $customshipping = Mage::getModel('customshipping/shipment')->load($this->getShipment()->getId());
                $destinationcity = $customshipping->getDestinationCity();
                $destinationpostcode = $customshipping->getDestinationPostcode();
                $rateRequest = new RateRequest();
                $pickupaddress = new PickUpAddresses();
                $adminselectedLocationId = Mage::getSingleton('core/session')->getSelectedLocation();

                if($adminselectedLocationId > 0) {
                    $adminselectedLocationDetails = Mage::getModel('customshipping/warehouse')->load($adminselectedLocationId)->getData();
                    $adminselectedLocationsuburb = $adminselectedLocationDetails['suburb'];
                    $adminselectedLocationzip = $adminselectedLocationDetails['zip'];
                    $pickupaddress->CountryCode = 'AUS';
                    $pickupaddress->CountryName = 'Australia';
                    $pickupaddress->PostCode = $adminselectedLocationzip;
                    $pickupaddress->Suburb = $adminselectedLocationsuburb;
                    $rateRequest->PickUpAddress = $pickupaddress;
                } else {
                    $pickupaddress->CountryCode = 'AUS';
                    $pickupaddress->CountryName = 'Australia';
                    $pickupaddress->PostCode = $candconfig['warehouse']['warehouse_code'];
                    $pickupaddress->Suburb = $candconfig['warehouse']['warehouse_suburb'];
                    $rateRequest->PickUpAddress = $pickupaddress;
                }

                $deliveryaddress = new DeliveryAddresses();
                $deliveryaddress->CountryCode = 'AUS';
                $deliveryaddress->CountryName = 'Australia';
                $deliveryaddress->PostCode = $destinationpostcode;
                $deliveryaddress->Suburb = $destinationcity;
                $rateRequest->DeliveryAddress = $deliveryaddress;

                $autoselectedBoxCheck1 = Mage::getSingleton('core/session')->getAutoSelectedBoxCheckStatus();
                $manualyCreateBoxes = Mage::getSingleton('core/session')->getManualyCreateBoxesArray();

                if(!empty($manualyCreateBoxes)) {
                    $manualyCreateBoxes = Mage::getSingleton('core/session')->getManualyCreateBoxesArray();

                    foreach($manualyCreateBoxes as $boxfilledProduct) {
                        $qty = $boxfilledProduct['gty'];
                        for($c = 1; $c<=$qty; $c++)
                        {
                            $parcel[$k] = new Parcel1();
                            $parcel[$k]->Height = $boxfilledProduct['height'];
                            $parcel[$k]->Length = $boxfilledProduct['length'];
                            $parcel[$k]->Width = $boxfilledProduct['width'];
                            $parcel[$k]->Weight = $boxfilledProduct['weight'];
                            $k++;
                        }
                    }

                }elseif(!empty($autoselectedBoxCheck1)) {
                    $avalableBoxArray = Mage::getSingleton('core/session')->getAvalableBoxArray();

                    foreach($avalableBoxArray as $boxfilledProduct) {
                        $parcel[$k] = new Parcel1();
                        $parcel[$k]->Height = $boxfilledProduct['BoxDetails']['height'];
                        $parcel[$k]->Length = $boxfilledProduct['BoxDetails']['length'];
                        $parcel[$k]->Width = $boxfilledProduct['BoxDetails']['width'];
                        $parcel[$k]->Weight = $boxfilledProduct['BoxDetails']['NetWeight'];
                        $k++;
                    }
                }
                else{
                    $collection = Mage::getResourceModel('sales/order_collection')
                        ->addFieldToFilter('increment_id', $incrementid)
                        ->addAttributeToSelect('*');

                    foreach ($collection as $col)
                    {
                        $customshippingorder = Mage::getModel('customshipping/order')->getCollection()
                            ->addFieldToFilter('order_id',$orderid)->getData();
                        foreach($customshippingorder as $coll){
                            $sku = $coll['product_sku'];
                            $qty = $coll['qty'];
                            $_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
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
                            $k2 = '';
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
                }


                if(count($parcel) != 0)
                    $k = count($parcel);
                $rateRequest->Parcel = $parcel;



                $key = new APIKey();
                $key->AuthKey = $apikey;
                $key->Password = $password;

                $auth = array('AuthKey'=>$apikey,'Password'=>$password);
                if($candconfig['general']['sandbox']=='1') {
                    $centinelClient = new SoapClient('https://live.couriersandfreight.com.au/CandFAPITest/Service.svc?wsdl',array("soap_version" => SOAP_1_1,"trace"=>1,'exceptions'=>true));
                    $header = new SoapHeader("https://live.couriersandfreight.com.au/CandFAPITest/Service.svc?wsdl", "APIKey", $auth,false);
                }else {
                    $centinelClient = new SoapClient('https://live.couriersandfreight.com.au/CandFAPILive/Service.svc?wsdl',array("soap_version" => SOAP_1_1,"trace"=>1,'exceptions'=>true));
                    $header = new SoapHeader("https://live.couriersandfreight.com.au/CandFAPILive/Service.svc?wsdl", "APIKey", $auth,false);
                }
                $centinelClient->__setSoapHeaders(array($header));
                $ratePara = new CFParam_Rate();
                $ratePara->key = $key;
                $ratePara->rateRequest = $rateRequest;
                $webservice = $centinelClient->Rate($ratePara);
                if($order->getShippingMethod() != ''){
                    $getshippingmethod = $order->getShippingMethod();
                } else {
                    $getshippingmethod = $order->getShippingMethod();
                }
                $shippingmethod = substr($getshippingmethod,21);

                $_i = 0;
                for($i = 0; $i< count($webservice->RateResult->RateCollection->Rate); $i++) {
                    $requestprice = $webservice->RateResult->RateCollection->Rate[$i]->CurrencyValue;
                    if($candconfig['markup']['markup_type'] == 'rate')
                    {
                        $markup = $candconfig['markup']['markup_price'];
                    } else if($candconfig['markup']['markup_type'] == 'percentage')
                    {
                        $markuppercent = $candconfig['markup']['markup_price'];
                        $markup = ($markuppercent/100)*$requestprice;
                    }
                    $servicename = $webservice->RateResult->RateCollection->Rate[$i]->ServiceName;
                    $carriertitle = $webservice->RateResult->RateCollection->Rate[$i]->CarrierName;
                    $eta = $webservice->RateResult->RateCollection->Rate[$i]->EtaText;
                    $carrierid = $carriertitle."_".$servicename;
                    $carriertitle .= " ( ".$servicename." )";
                    $price = $markup+$requestprice;

                    if($shippingmethod == $carrierid)
                    {
                        $customshippinggetmodel = Mage::getModel('customshipping/shipment')->getCollection()
                            ->addFieldToFilter('order_id',$orderid);
                        foreach($customshippinggetmodel as $coll)
                        {
                            $shipmenttableid = $coll['id'];
                        }
                        $tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
                        if ($this->getShipment()->getStatus() != Candf_Customshipping_Model_System_Config_Backend_Shipment_Status::BOOKED)
                        {
                            $customshippingmodel = Mage::getModel('customshipping/shipment')->load($shipmenttableid)
                                ->setCarrierId($webservice->RateResult->RateCollection->Rate[$i]->CarrierId)
                                ->setServiceId($webservice->RateResult->RateCollection->Rate[$i]->ServiceId)
                                ->setAdditionalInsurence($webservice->RateResult->RateCollection->Rate[$i]->AdditionalInsurencePremium)
                                ->setShippingCost($requestprice)
                                ->setMarkupCost($markup)
                                ->setEta($eta)
                                ->setCarrierName($carrierid)
                                ->setServiceName($servicename)
                                ->save();
                        }
                    }
                }


                return $webservice;
            }
        }
    }
}
