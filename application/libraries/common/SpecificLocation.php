<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('common/LocationInterface');
$CI->load->library('common/PSGC');

class SpecificLocation extends LocationInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
        $this->Region = new PSGC();
        $this->Province = new PSGC();
        $this->City = new PSGC();
        $this->Barangay = new PSGC();
    }

    public static function getFromVariable($variable) : LocationInterface
    {
        if ($variable instanceof LocationInterface) {
            return $variable;
        }
        return new SpecificLocation();
    }
}
