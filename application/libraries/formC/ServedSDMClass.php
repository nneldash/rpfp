<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/ServedSDMInterface');

class ServedSDMClass extends ServedSDMInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}

