<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BaseProperty
{
    public $davalue;
    public $datype;

    public function __construct($params = null)
    {
        if (!empty($params)) {
            if (array_key_exists(_VALUE, $params)) {
                $this->davalue = $params[_VALUE];
            }
            if (array_key_exists(_TYPE, $params)) {
                $this->datype = $params[_TYPE];
            }
        }
    }
}
