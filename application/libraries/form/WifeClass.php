<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form/WifeInterface');

class WifeClass extends WifeInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
    