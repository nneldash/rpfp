<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/GenerateFormCInterface');

class GenerateFormCClass extends GenerateFormCInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
