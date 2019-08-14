<?php
class Candf_Customshipping_Helper_Customshipping extends Mage_Core_Helper_Abstract
{

    public function loadConfig()
    {
        $settings = array();
        $items = array(
            'general/active','general/sandbox','general/merchantid','general/api','general/password','countries/sallowspecific','countries/specificcountry',
            'rule/rulestatus','insurance/status','insurance/insurance_markup','units/measure','units/weight','packaging/packagetype','packaging/length','packaging/width','packaging/height',
            'warehouse/warehouse_companyname','warehouse/warehouse_firstname','warehouse/warehouse_lastname','warehouse/warehouse_adrs1','warehouse/warehouse_adrs2',
            'warehouse/warehouse_code','warehouse/warehouse_suburb','warehouse/warehouse_state','warehouse/warehouse_country','warehouse/warehouse_email','warehouse/warehouse_telephone',
            'warehouse/warehouse_openhour','warehouse/warehouse_closehour','markup/markup_type','markup/markup_price','markup/shippingmethod_count','payment/payment_type','payment/creditcart_number',
            'payment/creditcart_type','payment/creditcart_custmername','payment/creditcart_cvv','payment/creditcart_expiry_month',
            'payment/creditcart_expiry_year','options/careername_caption','options/estimate_shipping_display','options/label_type','options/careername_display',
            'handlingfee/handlingfee_active','handlingfee/handlingfee_price','handlingfee/handlingfee_type'

        );
        foreach($items as $config)
        {
            $temp = explode('/', $config);
            $name = $temp[1];

            $settings[$name] = Mage::getStoreConfig('customshipping/' . $config);
        }
        return $settings;
    }
}
