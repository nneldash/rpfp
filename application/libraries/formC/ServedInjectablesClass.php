<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/ServedInjectablesInterface');

class ServedInjectablesClass extends ServedInjectablesInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}

