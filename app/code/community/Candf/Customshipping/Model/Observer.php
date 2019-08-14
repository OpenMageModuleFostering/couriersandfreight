<?php

class Candf_Customshipping_Model_Observer
{
    public function createCustomshippingShipment(Varien_Event_Observer $observer)
    {
        $order = $observer->getOrder();
        $candconfig = Mage::getStoreConfig('candf');
        if($candconfig['general']['active'] == 1)
        {
            if($candconfig['countries']['specificcountry'] == 'AU')
            {
                if($order->getShippingAddress()->getCountryId() == 'AU')
                {
                    $customshipping_shipment = Mage::getModel('customshipping/shipment');
                    $email = $order->getShippingAddress()->getEmail();
                    if(!$email)
                    {
                        $email = $order->getCustomerEmail();
                    }
                    if($order->getShippingMethod() != '')
                    {
                        $getsaved_shippingmethod = $order->getShippingMethod();
                        $getshippingmethodArray = explode('candf_customshipping_',$getsaved_shippingmethod);
                        $getshippingmethod = $getshippingmethodArray['1'];

                    } else {
                        $getsaved_shippingmethod = $order->getshipping_method();
                        $getshippingmethodArray = explode('candf_customshipping_',$getsaved_shippingmethod);
                        $getshippingmethod = $getshippingmethodArray['1'];
                    }
                    $customshipping = Mage::getModel('customshipping/shipment');
                    $customshipping->setOrderId($order->getId())
                        ->setStatus(Candf_Customshipping_Model_System_Config_Backend_Shipment_Status::PENDING)
                        ->setDestinationContactName($order->getShippingAddress()->getName())
                        ->setDestinationCompanyName($order->getShippingAddress()->getCompany())
                        ->setDestinationStreet($order->getShippingAddress()->getStreetFull())
                        ->setDestinationRegion($order->getShippingAddress()->getRegion())
                        ->setDestinationPhone($order->getShippingAddress()->getTelephone())
                        ->setDestinationEmail($email)
                        ->setDestinationCountry($order->getShippingAddress()->getCountryId())
                        ->setDestinationPostcode($order->getShippingAddress()->getPostcode())
                        ->setDestinationCity($order->getShippingAddress()->getCity())
                        ->setCustomerSelectedQuoteDescription($getshippingmethod)
                        ->setCustomerSelectedOptions($getshippingmethod)
                        ->setCarrierName($getshippingmethod)
                        ->save();

                    $customshippingorder = Mage::getModel('customshipping/order');
                    foreach($order->getAllItems() as $pitem)
                    {
                        if($pitem->getProductType != 'virtual')
                        {
                            $productid = $pitem->getProductId();
                            $_product= Mage::getSingleton('catalog/product')->load($productid);
                            $length = (int)$_product->getResource()->getAttribute('candf_length')->getFrontend()->getValue($_product);
                            $height = (int)$_product->getResource()->getAttribute('candf_height')->getFrontend()->getValue($_product);
                            $width =  (int)$_product->getResource()->getAttribute('candf_width')->getFrontend()->getValue($_product);
                            $weight = (int)$_product->getResource()->getAttribute('weight')->getFrontend()->getValue($_product);
                            $customshippingorder->setId()
                                ->setOrderId($order->getId())
                                ->setProductName($_product->getName())
                                ->setProductSku($_product->getSku())
                                ->setQty($pitem->getQtyOrdered())
                                ->setWeight($weight)
                                ->setHeight($height)
                                ->setLength($length)
                                ->setWidth($width)
                                ->save();
                        }
                    }
                }
                $getAdditionalServiceIds = Mage::getSingleton('core/session')->getAdditionalServiceId();
                if(!empty($getAdditionalServiceIds)) {

                    foreach($getAdditionalServiceIds as $getAdditionalServiceId) {

                        $customshipping_additional_service = Mage::getModel('customshipping/shipmentadditional');
                        $customshipping_additional_service->setOrderId($order->getId())
                            ->setAdditionalShipmentId($getAdditionalServiceId)
                            ->save();
                    }
                }
            }
        }
    }

    public function salesOrderShipmentSaveBefore($observer)
    {
        $additional_services_id = Mage::app()->getRequest()->getParams('additional-services');

        if(!empty($additional_services_id)) {

            $request_param = Mage::app()->getRequest()->getParams();
            Mage::getSingleton('core/session')->setAdditionalServiceId($request_param['additional-services']);
        }
    }

}