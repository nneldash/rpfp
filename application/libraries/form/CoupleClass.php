<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form/CoupleInterface');

class CoupleClass extends CoupleInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
    