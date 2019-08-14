<?php

class Candf_Customshipping_Model_System_Config_Backend_Packaging_Packagetype {

    protected $_options;

    const BAG = 1;
    const BOX = 2;
    const CARTON = 3;
    const CRATE = 4;
    const DRUM = 5;
    const ENVELOPE = 6;
    const PALLET = 7;
    const ROLL = 8;
    const SATCHELS = 9;
    const ANY = 11;
    const POSTER_TUBE = 15;
    const SKID = 16;
    const PIECES = 17;
    const PARCEL = 18;
    const PACKAGE = 19;

    public function toOptionArray() {
        return $this->_options = array
        (
            self::BAG               => 'Bag',
            self::BOX               => 'Box',
            self::CARTON            => 'Carton',
            self::CRATE             => 'Crate',
            self::DRUM              => 'Drum',
            self::ENVELOPE          => 'Envelop',
            self::PALLET            => 'Pallet',
            self::ROLL              => 'Roll',
            self::SATCHELS          => 'Satchels',
            self::ANY               => 'Any',
            self::POSTER_TUBE       => 'Poster Tube',
            self::SKID              => 'skid',
            self::PIECES            => 'Pieces',
            self::PARCEL            => 'Parcel',
            self::PACKAGE           => 'Package',
        );
    }

}