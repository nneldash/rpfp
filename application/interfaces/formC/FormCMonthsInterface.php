<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('formC/lists/ListServedBBTInterface');
$CI->load->iface('formC/lists/ListServedBillingsInterface');
$CI->load->iface('formC/lists/ListServedBTLInterface');
$CI->load->iface('formC/lists/ListServedCondomInterface');
$CI->load->iface('formC/lists/ListServedImplantInterface');
$CI->load->iface('formC/lists/ListServedInjectablesInterface');
$CI->load->iface('formC/lists/ListServedIUDInterface');
$CI->load->iface('formC/lists/ListServedLAMInterface');
$CI->load->iface('formC/lists/ListServedNSVInterface');
$CI->load->iface('formC/lists/ListServedPillsInterface');
$CI->load->iface('formC/lists/ListServedSDMInterface');
$CI->load->iface('formC/lists/ListServedSymptoThermalInterface');

abstract class FormCMonthsInterface extends BaseInterface
{
    /** @var ListServedBBTInterface */
    public $ListServedBBT;
    /** @var ListServedBillingsInterface */
    public $ListServedBillings;
    /** @var ListServedBTLInterface */
    public $ListServedBTL;
    /** @var ListServedCondomInterface */
    public $ListServedCondom;
    /** @var ListServedImplantInterface */
    public $ListServedImplant;
    /** @var ListServedInjectablesInterface */
    public $ListServedInjectables;
    /** @var ListServedIUDInterface */
    public $ListServedIUD;
    /** @var ListServedLAMInterface */
    public $ListServedLAM;
    /** @var ListServedNSVInterface */
    public $ListServedNSV;
    /** @var ListServedPillsInterface */
    public $ListServedPills;
    /** @var ListServedSDMInterface */
    public $ListServedSDM;
    /** @var ListServedSymptoThermalInterface */
    public $ListServedSymptoThermal;
}
