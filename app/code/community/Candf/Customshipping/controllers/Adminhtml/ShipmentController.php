<?php


ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
ini_set('default_socket_timeout', 100000);
class PickUpAddress
{
    public $CompanyName;
    public $CountryCode;
    public $CountryName;
    public $EmailAddress;
    public $FirstName;
    public $LastName;
    public $Line1;
    public $Line2;
    public $Line3;
    public $PostCode;
    public $Residential;
    public $Suburb;
    public $TelephoneNumber;
}

class DeliveryAddress
{
    public $CompanyName;
    public $CountryCode;
    public $CountryName;
    public $EmailAddress;
    public $FirstName;
    public $LastName;
    public $Line1;
    public $Line2;
    public $Line3;
    public $PostCode;
    public $Residential;
    public $Suburb;
    public $TelephoneNumber;
}

class CFParam_Rate1
{
    public $key;
    public $shipmentRequest;
}

class Parcel1
{
    public $Height;
    public $Length;
    public $Width;
    public $Weight;
    public $Type;
    public $GoodsDescriptionId;
}

class APIKey1
{
    public $AuthKey;
    public $Password;
}

class CreditCardInfo
{
    public $CardNumber;
    public $CardType;
    public $CustomerNameOnTheCard;
    public $Cvv;
    public $ExpiryDate;
}

class Type
{
    public $Type;
}
class AddtionalServiceandCharges
{
    public $CFserviceID;
    public $CarrierId;
    public $CarrierName;
    public $Cost;
    public $ServiceCode;
    public $ServiceDescription;
}

class PaymentInfo
{
    public $CreditCard;
    public $Type;
}

class ShipmentRequest
{
    public $AdditionalInsuranceCover;
    public $AuthorityToLeave;
    public $CarrierId;
    public $CurrencyCode;
    public $DeliveryAddress;
    public $Parcel;
    public $PickUpAddress;
    public $PriceScheduleId;
    public $PromoCode;
    public $RateFilterOption;
    public $ServiceId;
    public $DescriptionOfGoods;
    public $Payment;
    public $PickupCloseAt;
    public $PickupDate;
    public $PickupTime;
    public $PickupStartAt;
    public $ShipmentValue;
    public $Special_Instructions_For_Delivery;
    public $AdditionalService;
}



class Candf_Customshipping_Adminhtml_ShipmentController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('customshipping/shipment')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Shipment Manager'), Mage::helper('adminhtml')->__('Shipment Manager'))
            ->renderLayout();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $shipment = Mage::getModel('customshipping/shipment')->load($id);
        if ($shipment->getId())
        {
            $notices = array();
            Mage::register('customshipping_shipment_data', $shipment);
            $this->loadLayout()
                ->_setActiveMenu('customshipping/shipment');
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customshipping')->__('Shipment does not exist.'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        $manualyCreateBoxArray = $this->getRequest()->getPost('createmanualbox');

        if(isset($manualyCreateBoxArray)) {
            foreach($manualyCreateBoxArray as $manualyCreateBox) {

                $boxWaight = $manualyCreateBox['weight'];
                $boxLength = $manualyCreateBox['length'];
                $boxWidth = $manualyCreateBox['width'];
                $boxHeight = $manualyCreateBox['height'];
                $boxQty = $manualyCreateBox['gty'];
                $type = $manualyCreateBox['type'];
                $paper = $manualyCreateBox['paper'];


                if(!empty($boxWaight) && !empty($boxLength) && !empty($boxWidth) && !empty($boxHeight) ){

                    $productArray[] = array('type'=>$type,
                        'paper'=> $paper,
                        'weight'=>$boxLength,
                        'length'=>$boxWaight,
                        'width'=>$boxWidth,
                        'weight'=>$boxWaight,
                        'height'=>$boxHeight,
                        'gty'=>$boxQty
                    );

                }

            }

            $customBoxArray = $productArray;

        }

        $manualyCreateBoxesArray = Mage::getSingleton('core/session')->setManualyCreateBoxesArray($customBoxArray);

        $manualyCreateBoxes = $this->getRequest()->getPost('manualy_create_boxes');
        $avalableBoxArray = Mage::getSingleton('core/session')->getAvalableBoxArray();
        $getPostParam = $this->getRequest()->getPost();
        $autoselectedBox = $getPostParam['check_auto_selected_box'];
        if(isset($manualyCreateBoxes)) {
            $manualyCreateBoxes = Mage::getSingleton('core/session')->setManualyCreateBoxes($manualyCreateBoxes);


        }else {
            $manualyCreateBoxesArray = Mage::getSingleton('core/session')->setManualyCreateBoxesArray('');
        }


        if(isset($autoselectedBox)) {
            $autoselectedBoxCheck = Mage::getSingleton('core/session')->setAutoSelectedBoxCheckStatus($autoselectedBox);
        }else {
            $autoselectedBoxCheck = Mage::getSingleton('core/session')->setAutoSelectedBoxCheckStatus('');
        }


        /* set admin selected wahehouse for shipment*/
        $adminselectedlocation = $this->getRequest()->getPost('selected-wahehouseid');
        if(isset($adminselectedlocation)) {
            Mage::getSingleton('core/session')->setSelectedLocation($adminselectedlocation);
        }else {
            Mage::getSingleton('core/session')->setSelectedLocation('');
        }



        $candfordertableid = $this->getRequest()->getPost('id');
        $weight = $this->getRequest()->getPost('weight');
        $height = $this->getRequest()->getPost('height');
        $length = $this->getRequest()->getPost('length');
        $width = $this->getRequest()->getPost('width');
        $type = $this->getRequest()->getPost('type');




        $newrequestquote = $this->getRequest()->getPost('requestquote');
        $customshippingorder = Mage::getModel('customshipping/order');
        // $custompickupaddress = Mage::getModel('customshipping/pickupaddress');

        $customshippinggetmodel = Mage::getModel('customshipping/shipment')->getCollection()
            ->addFieldToFilter('order_id',$this->getRequest()->getPost('orderid'));
        foreach($customshippinggetmodel as $coll)
        {
            $shipmenttableid = $coll['id'];
        }

        if ( $this->getRequest()->getPost() )
        {
            try
            {
                $postData = $this->getRequest()->getPost();
                $customshippingmodel = Mage::getModel('customshipping/shipment')->load($shipmenttableid)
                    ->setDestinationContactName($postData['destination_contact_name'])
                    ->setDestinationCompanyName($postData['destination_company_name'])
                    ->setDestinationStreet($postData['destination_street'])
                    ->setDestinationCity($postData['destination_city'])
                    ->setDestinationRegion($postData['destination_region'])
                    ->setDestinationPostcode($postData['destination_postcode'])
                    ->setDestinationCountry($postData['destination_country'])
                    ->setDestinationPhone($postData['destination_phone'])
                    ->setSpecialinstructions($postData['specialinstructions'])
                    ->setDestinationEmail($postData['destination_email']);
                if($postData['ready'] == 1){
                    $customshippingmodel->setReadyDate($postData['ready_date']);
                } else {
                    $customshippingmodel->setAsap(1);
                    $customshippingmodel->setReadyDate($postData['ready']);
                }
                $pickuptime = $postData['pickuptime'].$postData['pickuptimenote'];
                $pickupstarttime = $postData['pickupstarttime'];
                $pickupclosetime = $postData['pickupclosetime'];
                $customshippingmodel->setDestinationCountry($postData['destination_country'])
                    ->setPickupstarttime($postData['pickupstarttime']);
                if($postData['pickupclosetime'] != ''){
                    $customshippingmodel->setPickupclosetime($postData['pickupclosetime']);
                }
                $customshippingmodel->setPickupStart($newrequestquote)
                    ->save();


                foreach($candfordertableid as $key => $id){
                    $customshippingorder->setId($id)
                        ->setWeight($weight[$key])
                        ->setHeight($height[$key])
                        ->setLength($length[$key])
                        ->setWidth($width[$key])
                        ->setType($type[$key])
                        ->save();
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The shipment data has been saved. You can place booking using the below "Make Booking" link'));
                Mage::getSingleton('adminhtml/session')->setCustomshippingData(false);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCustomshippingData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }


    public function validatebookAction()
    {
        $shipment_id = $this->getRequest()->getParam('shipment');

        $shipment = Mage::getModel('customshipping/shipment')
            ->load($shipment_id);
        $this->_getSession()->addError('Please click Save and Get Quotes button and click make Booking link');
        $this->_redirect('*/*/edit', array('id' => $shipment_id));
    }

    public function bookAction()
    {

        $shipment_id = $this->getRequest()->getParam('shipment');
        //print_r($shipment_id);
        $shipment = Mage::getModel('customshipping/shipment')
            ->load($shipment_id);

        $quote_id = $this->getRequest()->getParam('quote');
        $newcarrierid = $this->getRequest()->getParam('carrierid');
        $newserviceid = $this->getRequest()->getParam('serviceid');
        $newcost = $this->getRequest()->getParam('cost');
        $newcarriername = $this->getRequest()->getParam('carriername');
        $neweta = $this->getRequest()->getParam('eta');

        //getting selected additional servicess
        $orderid = $shipment['order_id'];
        //$additionalServiceId = $this->getRequest()->getParam('additional-servicess');





        try
        {
            $booking_result = $this->_makeBooking($shipment, $quote_id, $shipment_id, $newcarrierid, $newserviceid, $newcost, $newcarriername, $neweta,$orderid);
        } catch (Exception $ex)
        {
            $error = $ex->getMessage();
        }

        if($booking_result['passed']==0){
            $this->_getSession()->addError($this->__($booking_result['reply']));

        }else{

            $booking_result_new = $booking_result['reply'];

            $shipment
                ->setAdminSelectedQuoteId($quote_id)
                ->setBookingRequestId();
            if($newcarrierid == ''){
                $shipment->setBookingNumber($booking_result_new);
            }
            $shipment->setConsignmentNumber()
                ->setConsignmentDocument()
                ->setConsignmentDocumentType()
                ->setLabelDocument()
                ->setLabelDocumentType()
                ->setStatus(Candf_Customshipping_Model_System_Config_Backend_Shipment_Status::BOOKED)
                ->setAnticipatedCost()
                ->save();


            $OrderId = $shipment->getOrderId();
            $getorder = Mage::getModel('sales/order')->load($OrderId);

            $magento_shipment = Mage::getModel('sales/convert_order')
                ->toShipment($getorder);


            $totalQty = 0;


            foreach ($getorder->getAllItems() as $item)
            {
                if ($item->getQtyToShip() && !$item->getIsVirtual())
                {
                    $magento_shipment_item = Mage::getModel('sales/convert_order')
                        ->itemToShipmentItem($item);
                    $qty = $item->getQtyToShip();
                    $magento_shipment_item->setQty($qty);
                    $magento_shipment->addItem($magento_shipment_item);
                    $totalQty += $qty;
                }
            }
            $magento_shipment->setTotalQty($totalQty);
            $track = Mage::getModel('sales/order_shipment_track');
            $number = '';
            if ($booking_result_new->consignmentNumber)
            {
                $number .= 'Consignment Number: ' . $booking_result_new->consignmentNumber;
            }
            if ($booking_result_new->requestId)
            {
                if ($number)
                {
                    $number .= "\n<br />";
                }
                $number .= 'Request Id: ' . $booking_result_new->requestId;
            }
            //$getorder = $shipment->getOrder();
            if($getorder->getShippingMethod() != '')
            {
                $getshippingmethod = $getorder->getShippingMethod();
            } else {
                $getshippingmethod = $getorder->getshipping_method();
            }
            $getshippingmethods = explode("_",$getshippingmethod);
            $shippingmethod = implode(" ",array_slice($getshippingmethods, 2));
            $track
                ->setCarrierCode()
                ->setTitle($shippingmethod)
                ->setNumber($booking_result);

            $magento_shipment
                ->addTrack($track)
                ->register();

            try
            {
                $magento_shipment->getOrder()->setIsInProcess(true)->setCustomerNoteNotify(true);
                Mage::getModel('core/resource_transaction')
                    ->addObject($shipment)
                    ->addObject($magento_shipment)
                    ->addObject($magento_shipment->getOrder())
                    ->save();
                $magento_shipment->sendEmail();
            } catch (Mage_Core_Exception $e)
            {
                $error = $e->getMessage();
            }
            $this->_getSession()->addSuccess($this->__('Shipment booked.'));
            if ($error)
            {
                $this->_getSession()
                    ->addError($this->__($error));
            }
        }

        $this->_redirect('*/*/edit', array('id' => $shipment_id));
    }


    public function _makeBooking($shipment,$quote,$shipment_id,$newcarrierid,$newserviceid,$newcost,$newcarriername,$neweta,$orderid)
    {
        $shipRequest = new ShipmentRequest();
        $requestaa = $this->getRequest();

        $order = Mage::getModel('sales/order')->load($orderid);

        $order = Mage::getModel('sales/order')->load($orderid);
        $incrementid = $order->getIncrementId();


        $deliveryfirstname = $order->getShippingAddress()->getFirstname();
        $deliverylastname = $order->getShippingAddress()->getLastname();
        $deliverycompany = $order->getShippingAddress()->getCompany();
        $deliverystreet = $order->getShippingAddress()->getStreetFull();
        $deliveryregion = $order->getShippingAddress()->getRegion();
        $deliverycity = $order->getShippingAddress()->getCity();
        $deliverypostcode = $order->getShippingAddress()->getPostcode();
        $deliverycountry = $order->getShippingAddress()->getCountry_id().'S';
        // $deliveryemail = $order->getShippingAddress()->getDestinationEmail();
        // $deliverytelephone = $order->getShippingAddress()->getDestinationPhone();
        $deliveryemail = $order->getShippingAddress()->getEmail();
        $deliverytelephone = $order->getShippingAddress()->getTelephone();

        $deliveryaddress = new DeliveryAddress();
        $deliveryaddress->CompanyName = $deliverycompany;
        $deliveryaddress->CountryCode = 'AUS';
        $deliveryaddress->CountryName = 'Australia';
        $deliveryaddress->FirstName = $deliveryfirstname;
        $deliveryaddress->LastName = $deliverylastname;
        $deliveryaddress->Line1 = $deliverystreet;
        $deliveryaddress->PostCode = $deliverypostcode;
        $deliveryaddress->Suburb = $deliverycity;
        $deliveryaddress->EmailAddress = $deliveryemail;
        $deliveryaddress->TelephoneNumber = $deliverytelephone;
        $shipRequest->DeliveryAddress = $deliveryaddress;

        //$this->settings = Mage::helper('customshipping/customshipping')->loadConfig();
        $candconfig = Mage::getStoreConfig('candf');

        $apikey = $candconfig['general']['api'];
        $password = $candconfig['general']['password'];
        $pickupcompanyname = $candconfig['warehouse']['warehouse_companyname'];
        $pickupfirstname = $candconfig['warehouse']['warehouse_firstname'];
        $pickuplastname = $candconfig['warehouse']['warehouse_lastname'];
        $pickupemail = $candconfig['warehouse']['warehouse_email'];
        $pickuptelephone = $candconfig['warehouse']['warehouse_telephone'];
        $pickupstreet1 = $candconfig['warehouse']['warehouse_adrs1'];
        $pickupstreet2 = $candconfig['warehouse']['warehouse_adrs2'];

        $pickuppostcode = $candconfig['warehouse']['warehouse_code'];
        $pickupregion = $candconfig['warehouse']['warehouse_suburb'];
        $pickupstate = $candconfig['warehouse']['warehouse_state'];
        $pickupcountry = $candconfig['warehouse']['warehouse_country'].'S';

        $pickupaddress = new PickUpAddress();

        $adminselectedLocationId = Mage::getSingleton('core/session')->getSelectedLocation();

        if($adminselectedLocationId > 0) {
            $adminselectedLocationDetails = Mage::getModel('customshipping/warehouse')->load($adminselectedLocationId)->getData();



            $pickupaddress->CountryCode = 'AUS';
            $pickupaddress->CountryName = 'Australia';
            $pickupaddress->CompanyName = $adminselectedLocationDetails['company_name'];
            $pickupaddress->FirstName = $adminselectedLocationDetails['contact_name'];
            $pickupaddress->LastName = $adminselectedLocationDetails['contact_name'];
            $pickupaddress->EmailAddress = $adminselectedLocationDetails['contact_email'];
            $pickupaddress->TelephoneNumber = $adminselectedLocationDetails['phone1'];
            $pickupaddress->CountryCode = 'AUS';
            $pickupaddress->CountryName = 'Australia';
            $pickupaddress->Line1 = $adminselectedLocationDetails['line1'];
            $pickupaddress->Line2 = $adminselectedLocationDetails['line2'];
            $pickupaddress->PostCode = $adminselectedLocationDetails['zip'];
            $pickupaddress->Suburb = $adminselectedLocationDetails['suburb'];

        } else{
            $pickupaddress->CompanyName = $pickupcompanyname;
            $pickupaddress->FirstName = $pickupfirstname;
            $pickupaddress->LastName = $pickuplastname;
            $pickupaddress->EmailAddress = $pickupemail;
            $pickupaddress->TelephoneNumber = $pickuptelephone;
            $pickupaddress->CountryCode = 'AUS';
            $pickupaddress->CountryName = 'Australia';
            $pickupaddress->Line1 = $pickupstreet1;
            $pickupaddress->Line2 = $pickupstreet2;
            $pickupaddress->PostCode = $pickuppostcode;
            $pickupaddress->Suburb = $pickupregion;

        }

        $shipRequest->PickUpAddress = $pickupaddress;
        $api = new APIKey1();
        $api->AuthKey = $apikey;
        $api->Password = $password;

        $creditcardno = $candconfig['payment']['creditcart_number'];
        $creditcardtype = $candconfig['payment']['creditcart_type'];
        $creditcardcustomername = $candconfig['payment']['creditcart_custmername'];
        $creditcardcvv = $candconfig['payment']['creditcart_cvv'];
        $creditcardexmonth = $candconfig['payment']['creditcart_expiry_month'];
        $creditcardexyear = $candconfig['payment']['creditcart_expiry_year'];
        $type = 'PayAsYouGo';

        $creditcardinfo = new CreditCardInfo();

        $creditcardinfo->CardNumber = $creditcardno;
        $creditcardinfo->CardType = $creditcardtype;
        $creditcardinfo->CustomerNameOnTheCard = $creditcardcustomername;
        $creditcardinfo->Cvv = $creditcardcvv;
        $creditcardinfo->ExpiryDate = $creditcardexmonth.'/'.$creditcardexyear;

        $paymentinfo = new PaymentInfo();
        $paymentinfo->CreditCard = $creditcardinfo;
        $paymentinfo->Type = 'PayAsYouGo';
        $shipRequest->Payment = $paymentinfo;
        //$shipRequest->Payment = $accounttype;

        $customshipping = Mage::getModel('customshipping/shipment')->load($shipment_id);



        $additionalinsurance = $customshipping->getAdditionalInsurence();
        $authoritytoleave = true;
        $carrierid = $customshipping->getCarrierId();
        $serviceid = $customshipping->getServiceId();
        $shippingcost = $customshipping->getShippingCost();
        $pickupreversedate = $customshipping->getReadyDate();
        if($pickupreversedate != '')
        {
            $datestring = explode("-",$pickupreversedate);
            $pickupdate = $datestring[2].'-'.$datestring[1].'-'.$datestring[0];
        } else
        {
            $tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
            $pickupdate = date("Y-m-d", $tomorrow);
        }
        $pickuptime = $customshipping->getReadyTime().$customshipping->getReadyTimenote();
        $pickupstarttime = $customshipping->getPickupstarttime();
        $pickupclosetime = $customshipping->getPickupclosetime();
        $customshipping->setReadyDate($pickupdate)
            ->setPickupstarttime($pickupstarttime)
            ->setPickupclosetime($pickupclosetime)
            ->save();
        $shipRequest->AdditionalInsuranceCover = $additionalinsurance;
        $shipRequest->AuthorityToLeave = $authoritytoleave;
        if($newcarrierid == ''){
            $shipRequest->CarrierId = $carrierid;
            $shipRequest->ServiceId = $serviceid;
            $shipRequest->ShipmentValue = $shippingcost;
        } else {
            $shipRequest->CarrierId = $newcarrierid;
            $shipRequest->ServiceId = $newserviceid;
            $shipRequest->ShipmentValue = $newcost;
        }
        $shipRequest->CurrencyCode = 'AUD';
        $shipRequest->PickupCloseAt = $pickupclosetime;
        //$shipRequest->PickupCloseAt = '1600';
        $shipRequest->PickupDate = $pickupdate;
        $shipRequest->PickupStartAt = $pickupstarttime;
        //$shipRequest->PickupStartAt = '1000';
        $shipRequest->Special_Instructions_For_Delivery = $customshipping->getSpecialinstruction();
        $shipRequest->BookingSource = 'magento';


        $autoselectedBoxCheck1 = Mage::getSingleton('core/session')->getAutoSelectedBoxCheckStatus();
        $manualyCreateBoxes = Mage::getSingleton('core/session')->getManualyCreateBoxesArray();


        $autoselectedBoxCheck1 = Mage::getSingleton('core/session')->getAutoSelectedBoxCheckStatus();
        $manualyCreateBoxes = Mage::getSingleton('core/session')->getManualyCreateBoxesArray();

        $k =0;
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
                    $k = '';


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

                    $parcel = array();
                    for ($c = 1; $c <= $qty; $c++) {


                        $arr_main = new Parcel1();
                        $arr_main->GoodsDescriptionId= '0';
                        //$parcel[$k]->Type = (string)$coll['product_name'];
                        $arr_main->Height = $height;
                        $arr_main->Length = $length;
                        $arr_main->Width = $width;
                        $arr_main->Weight = $weight;
                        //$k++;

                        $parcel[] = $arr_main;

                    }

                    $additinalParcel = array();
                    if(!empty($additionalQty)) {
                        for ($c = 1; $c <= $additionalQty; $c++) {
                            $aditional_parcel = new Parcel1();
                            $aditional_parcel->GoodsDescriptionId = '0';
                            //$parcel[$k]->Type = (string)$coll['product_name'];
                            $aditional_parcel->Height = $proHeight;
                            $aditional_parcel->Length = $proLenght;
                            $aditional_parcel->Width = $proWidth;
                            $aditional_parcel->Weight = $proWeight;
                            $additinalParcel[] = $aditional_parcel;
                        }
                    }

                }


            }
            if(!empty($additinalParcel)) {
                foreach($additinalParcel as $aditional_parcelArr) {


                    array_push($parcel,$aditional_parcelArr);
                }

            }

        }



        $shipRequest->Parcel = $parcel;

        $collection = Mage::getModel('customshipping/shipmentadditional')->getCollection();
        $getAdditionalServiceData= $collection->addFieldToFilter('order_id', array('in' =>array('in' => array($orderid))))->getData();
        if(!empty($getAdditionalServiceData)) {

            $collection = Mage::getModel('customshipping/additionalservices')->getCollection();
            $getAdditionalServiceDataArry= $collection->addFieldToFilter('id', array('in' =>array('in' => array($getAdditionalServiceData))))->getData();

            $arrAdditionalService = array();
            foreach($getAdditionalServiceDataArry as $selectedAdditinalService) {
                $addtionalServiceandCharges = new AddtionalServiceandCharges();
                $addtionalServiceandCharges->CFserviceID = $selectedAdditinalService['Mapping_CF_Service_Id'];
                $addtionalServiceandCharges->CarrierId = $selectedAdditinalService['Carrier_Id'];
                $addtionalServiceandCharges->CarrierName = $selectedAdditinalService['Carrier_Name'];
                $addtionalServiceandCharges->Cost = $selectedAdditinalService['Carrier_Basic_Charge'];
                $addtionalServiceandCharges->ServiceCode = $selectedAdditinalService['Carrier_Service_Code'];
                $addtionalServiceandCharges->ServiceDescription = $selectedAdditinalService['Carrier_Service_Description'];
                $arrAdditionalService[] = $addtionalServiceandCharges;
            }

            $shipRequest->AdditionalService = $arrAdditionalService;
        }


        $auth = array('AuthKey'=>$candconfig['general']['api'],'Password'=>$candconfig['general']['password']);


        if($candconfig['general']['sandbox']=='1') {
            $centinelClient = new SoapClient('https://live.couriersandfreight.com.au/CandFAPITest/Service.svc?wsdl',array("soap_version" => SOAP_1_1,"trace"=>1,'exceptions'=>true));
            $header = new SoapHeader("https://live.couriersandfreight.com.au/CandFAPITest/Service.svc?wsdl", "APIKey", $auth,false);

        }else {
            $centinelClient = new SoapClient('https://live.couriersandfreight.com.au/CandFAPILive/Service.svc?wsdl',array("soap_version" => SOAP_1_1,"trace"=>1,'exceptions'=>true));
            $header = new SoapHeader("https://live.couriersandfreight.com.au/CandFAPILive/Service.svc?wsdl", "APIKey", $auth,false);
        }

        $centinelClient->__setSoapHeaders(array($header));
        $shipPara = new CFParam_Rate1();
        $shipPara->key = $api;



        $shipPara->shipmentRequest = $shipRequest;


        $webservice = $centinelClient->CreateBooking($shipPara);

        if($webservice->CreateBookingResult->Status == 'FAIL'){

            $errorMsg = $webservice->CreateBookingResult->Message;

            if (strpos($errorMsg, "expired") !== NULL) {
                list($errorMsg, $b) = explode(' at ', $errorMsg);
            }

            return array( 'passed'=>0, 'reply'=> $errorMsg);
        }else{
            $custombooking = Mage::getModel('customshipping/booking')
                ->setBookingNumber($webservice->CreateBookingResult->BookingCode)
                ->setOrderId($order->getId());
            if($newcarrierid == ''){
                $custombooking->setShippingCost($shippingcost)
                    ->setCarrierId($carrierid)
                    ->setServiceId($serviceid);
            } else {
                $custombooking->setShippingCost($newcost)
                    ->setCarrierId($newcarrierid)
                    ->setServiceId($newserviceid);
            }
            $custombooking->save();

            if($candconfig['markup']['markup_type'] == 'rate')
            {
                $markup = $candconfig['markup']['markup_price'];
            } else if($candconfig['markup']['markup_type'] == 'percentage')
            {
                $markuppercent = $candconfig['markup']['markup_price'];
                $markup = ($markuppercent/100)*$requestprice;
            }
            if($candconfig['handlingfee']['handlingfee_active'] == 1)
            {
                if($candconfig['handlingfee']['handlingfee_type'] == 'rate'){
                    $handlingFee = $candconfig['handlingfee']['handlingfee_price'];
                }elseif($candconfig['handlingfee']['handlingfee_type'] == 'percentage'){
                    $handlingFeePercent = $candconfig['handlingfee']['handlingfee_price'];
                    $handlingFee = ($handlingFeePercent/100)*$requestprice;
                }
            }else{
                $handlingFee=0.00;
            }

            if($candconfig['insurance']['status'] == 'mandatory'){
                $insuranceMarkup = $candconfig['insurance']['insurance_markup'];
            }else{
                $insuranceMarkup = 0.00;
            }
            $newcarrierfullname = explode('_',$newcarriername);

            if($newcarrierid != ''){
                $custombooking = Mage::getModel('customshipping/shipmenthistory')
                    ->setBookingNumber($webservice->CreateBookingResult->BookingCode)
                    ->setOrderId($order->getId())
                    ->setCarrierId($newcarrierid)
                    ->setServiceId($newserviceid)
                    ->setShippingCost($newcost)
                    ->setMarkupCost($markup)
                    ->setEta($neweta)
                    ->setCarrierName($newcarrierfullname[0])
                    ->setServiceName($newcarrierfullname[1])
                    ->setNotes('Admin Selected')
                    ->save();
            }

            return array( 'passed'=>1, 'reply'=> $webservice->CreateBookingResult->BookingCode);
        }
    }
}