<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formB/formBInterface');
$CI->load->library('formB/lists/ListFormBMonthsClass');

class FormBClass extends FormBInterface
{
    public function __construct($params = null)
    {
        $this->ListMonth = new ListFormBMonthsClass();

        parent::__construct($params);
    }
}
