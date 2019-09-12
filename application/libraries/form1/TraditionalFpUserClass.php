<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form1/TraditionalFpUserInterface');

class TraditionalFpUserClass extends TraditionalFpUserInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
