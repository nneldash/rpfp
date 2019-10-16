<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form1/SeminarInterface');
$CI->load->library('form1/SeminarType');
$CI->load->library('common/SpecificLocation');

class SeminarClass extends SeminarInterface
{
    public function __construct($params = null)
    {
        $this->TypeOfClass = new SeminarType();
        $this->Location = new SpecificLocation();
        parent::__construct($params);
    }

}
    