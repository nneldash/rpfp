<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formB/FormBMonthsInterface');
$CI->load->library('formB/lists/ListCouplesUnmetNeedClass');
$CI->load->library('formB/lists/ListClientsUnmetNeedClass');
$CI->load->library('formB/lists/ListCouplesUsingTraditionalFpClass');
$CI->load->library('formB/lists/ListClientsUsingTraditionalFpClass');
$CI->load->library('formB/lists/ListTotalUnmetNeedClass');
$CI->load->library('formB/lists/ListTotalClientsClass');

class FormBMonthsClass extends FormBMonthsInterface
{
    public function __construct($params = null)
    {
        $this->ListCouplesUnmetNeed = new ListCouplesUnmetNeedClass();
        $this->ListClientsUnmetNeed = new ListClientsUnmetNeedClass();
        $this->ListCouplesUsingTraditionalFp = new ListCouplesUsingTraditionalFpClass();
        $this->ListClientsUsingTraditionalFp = new ListClientsUsingTraditionalFpClass();
        $this->ListTotalUnmetNeed = new ListTotalUnmetNeedClass();
        $this->ListTotalClientsNeed = new ListTotalClientsNeedClass();

        parent::__construct($params);
    }
}
