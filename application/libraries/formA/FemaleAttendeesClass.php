<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/FemaleAttendeesInterface');

class FemaleAttendeesClass extends FemaleAttendeesInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
