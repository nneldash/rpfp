<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/GenerateFormAInterface');

class GenerateFormAClass extends GenerateFormAInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
