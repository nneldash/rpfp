<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form1/IndividualInterface');
$CI->load->library('form1/NameClass');

class IndividualClass extends IndividualInterface
{
    public function __construct($params = null)
    {
        $this->Name = new NameClass();
        
        parent::__construct($params);
    }
}
    