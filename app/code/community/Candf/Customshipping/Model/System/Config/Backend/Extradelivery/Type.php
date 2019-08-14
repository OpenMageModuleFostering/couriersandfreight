<?php

class Candf_Customshipping_Model_System_Config_Backend_Extradelivery_Type {

    protected $_options;

    const TAILGATE = 'Tailgate lifter required';
    const DRIVER_TO_HAND_UNLOAD = 'Can you assist the driver to hand unload?';
    const CONTAINER = 'Container swing lifter required';
    const FORKLIFT = 'Forklift already on-site';
    const ORDER_FROM_A_TRANSPORT = 'Will you be able to collect this order from a transport,if required?';
    const LOADING_DOCK = 'Loading dock on-site';

    public function toOptionArray() {
        return $this->_options = array(
            self::TAILGATE => 'Tailgate lifter required',
            self::DRIVER_TO_HAND_UNLOAD => 'Can you assist the driver to hand unload?',
            self::CONTAINER => 'Container swing lifter required',
            self::FORKLIFT => 'Forklift already on-site',
            self::ORDER_FROM_A_TRANSPORT => 'Will you be able to collect this order from a transport,if required?',
            self::LOADING_DOCK => 'Loading dock on-site',
        );

    }
}
