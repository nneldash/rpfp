<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/MonthsInterface');
$CI->load->library('formC/lists/ListCouplesUnmetNeedClass');
$CI->load->library('formC/lists/ListClientsUnmetNeedClass');
$CI->load->library('formC/lists/ListCouplesUsingTraditionalFpClass');
$CI->load->library('formC/lists/ListClientsUsingTraditionalFpClass');
$CI->load->library('formC/lists/ListTotalUnmetNeedClass');
$CI->load->library('formC/lists/ListTotalClientsClass');

class MonthsClass extends MonthsInterface
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
