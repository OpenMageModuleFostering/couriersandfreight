<?php
class Candf_Customshipping_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Gets the date when a package will be ready to ship. Adjusts dates so
     * that they always fall on a weekday.
     *
     * @param <type> $ready_time timestamp for when the package will be ready
     * to ship, defaults to 10 days from current date
     */
    public function getReadyDate($ready_time = NULL)
    {
        if (is_null($ready_time)) {
            $ready_time = strtotime('+10 days');
        }
        if (is_numeric($ready_time) && $ready_time >= strtotime(date('Y-m-d'))) {
            $weekend_days = array('6', '7');
            while (in_array(date('N', $ready_time), $weekend_days)) {
                $ready_time = strtotime('+1 day', $ready_time);
            }
            return $ready_time;
        }
    }


}
	 