<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class ServiceSlipInterface extends BaseInterface
{
    public $DateOfVisit;
    public $ClientName;
    public $ClientAddress;
    public $MethodUsed;
    public $DateOfMethod;
    public $ClientAdvised;
    public $ReferralFacility;
    public $Name;
}
