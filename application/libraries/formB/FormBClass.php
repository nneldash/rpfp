<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formB/formBInterface');
$CI->load->library('formB/lists/ListMonthsClass');

class FormBClass extends FormBInterface
{
    public function __construct($params = null)
    {
        $this->ListMonth = new ListMonthsClass();

        parent::__construct($params);
    }
}
