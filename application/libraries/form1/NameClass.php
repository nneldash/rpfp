<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form1/NameInterface');

class NameClass extends NameInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
    