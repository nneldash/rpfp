<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BaseProperty
{
    public $value;
    public $type;

    public function __construct($params = null)
    {
        if (!empty($params)) {
            if (array_key_exists(_VALUE, $params)) {
                $this->value = $params[_VALUE];
            }
            if (array_key_exists(_TYPE, $params)) {
                $this->type = $params[_TYPE];
            }
        }
    }
}
