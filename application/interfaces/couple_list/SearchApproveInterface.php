<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class SearchApproveInterface extends BaseInterface
{
    public $LocationCode;
    public $ClassNo;
    public $DateConductedFrom;
    public $DateConductedTo;
    public $TypeOfClass;
    public $Name;
    public $AgeFrom;
    public $AgeTo;
    public $NoOfChildren;
    public $FpType;
    public $FpUser;
    public $NonFpUser;
    public $IntentionStatus;
}