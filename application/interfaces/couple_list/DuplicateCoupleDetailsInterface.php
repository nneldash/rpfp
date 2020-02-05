<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class DuplicateCoupleDetailsInterface extends BaseInterface
{
    public $CouplesId;
    public $Address_No_St;
    public $Address_Barangay;
    public $Address_City;
    public $Household_No;
    public $Number_Child;
    public $Status_Active;
    public $Fp_Details_Id;
    public $Mfp_Used;
    public $Mfp_Shift;
    public $Tfp_Type;
    public $Tfp_Status;
    public $Mfp_Intention_Use;
    public $Reason_Use;
}
