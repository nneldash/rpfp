<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form1/AddressInterface');

class AddressClass extends AddressInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
