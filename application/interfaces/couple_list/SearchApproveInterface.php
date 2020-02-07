<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class SearchApproveInterface extends BaseInterface
{
    public $ProvinceCode;
    public $MunicipalityCode;
    public $BarangayCode;
    public $ClassNo;
    public $DateConductedFrom;
    public $DateConductedTo;
    public $TypeOfClass;
    public $CoupleName;
    public $AgeFrom;
    public $AgeTo;
    public $NoOfChildren;
    public $ModernFpUser;
    public $NonModernFpUser;
    public $IntentionStatus;
    public $IntentionToUse;
}