<?php

abstract class Candf_Customshipping_Model_System_Config_Backend
{

    /**
     * The array of options in the configuration item.
     *
     * This array's keys are the values used in the database etc. and the
     * values of this array are used as labels on the frontend.
     *
     * @var array
     */
    protected $_options;

    public function __construct()
    {
        $this->_setupOptions();
    }


    protected abstract function _setupOptions();

    /**
     * Gets all the options in the key => value type array.
     *
     * @return array
     */
    public function getOptions($please_select = false)
    {
        $options = $this->_options;
        if ($please_select) {
            $options = array(null => '--Please Select--') + $options;
        }
        return $options;
    }

    /**
     * Converts the options into a format suitable for use in the admin area.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray($this->_options);
    }

    protected function _toOptionArray($input)
    {
        $array = array();

        foreach ($input as $key => $value) {
            $array[] = array(
                'value' => $key,
                'label' => $value,
            );
        }

        return $array;
    }

    /**
     * Looks up an option by key and gets the label.
     *
     * @param mixed $value
     * @return mixed
     */
    public function getOptionLabel($value)
    {
        if (array_key_exists($value, $this->_options)) {
            return $this->_options[$value];
        }
        return null;
    }

}
