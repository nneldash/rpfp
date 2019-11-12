<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/formCInterface');
$CI->load->library('formC/lists/ListMonthsClass');

class FormCClass extends FormCInterface
{
    public function __construct($params = null)
    {
        $this->ListMonth = new ListMonthsClass();

        parent::__construct($params);
    }
}
