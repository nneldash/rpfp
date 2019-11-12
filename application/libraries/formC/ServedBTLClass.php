<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/ServedBTLInterface');

class ServedBTLClass extends ServedBTLInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}

