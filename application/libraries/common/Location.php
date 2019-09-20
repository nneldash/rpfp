<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('common/LocationInterface');
$CI->load->library('common/PSGC');

class Location extends LocationInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
        $this->Region = new PSGC();
        $this->Province = new PSGC();
        $this->Municipality = new PSGC();
        $this->SpecificLocation = new PSGC();
    }
}
