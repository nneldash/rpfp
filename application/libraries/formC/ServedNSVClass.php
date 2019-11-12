<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/ServedNSVInterface');

class ServedNSVClass extends ServedNSVInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}

