<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/formCMonthsInterface');
$CI->load->library('formC/lists/ListServedBBTClass');
$CI->load->library('formC/lists/ListServedBillingsClass');
$CI->load->library('formC/lists/ListServedBTLClass');
$CI->load->library('formC/lists/ListServedCondomClass');
$CI->load->library('formC/lists/ListServedImplantClass');
$CI->load->library('formC/lists/ListServedInjectablesClass');
$CI->load->library('formC/lists/ListServedIUDClass');
$CI->load->library('formC/lists/ListServedLAMClass');
$CI->load->library('formC/lists/ListServedNSVClass');
$CI->load->library('formC/lists/ListServedPillsClass');
$CI->load->library('formC/lists/ListServedSDMClass');
$CI->load->library('formC/lists/ListServedSymptoThermalClass');
$CI->load->library('formC/lists/ListTotalClientsClass');

class formCMonthsClass extends FormCMonthsInterface
{
    public function __construct($params = null)
    {
        $this->ListServedBBT = new ListServedBBTClass();
        $this->ListServedBillings = new ListServedBillingsClass();
        $this->ListServedBTL = new ListServedBTLClass();
        $this->ListServedCondom = new ListServedCondomClass();
        $this->ListServedImplant = new ListServedImplantClass();
        $this->ListServedInjectables = new ListServedInjectablesClass();
        $this->ListServedIUD = new ListServedIUDClass();
        $this->ListServedLAM = new ListServedLAMClass();
        $this->ListServedNSV = new ListServedNSVClass();
        $this->ListServedPills = new ListServedPillsClass();
        $this->ListServedSDM = new ListServedSDMClass();
        $this->ListServedSymptoThermal = new ListServedSymptoThermal();

        parent::__construct($params);
    }
}
