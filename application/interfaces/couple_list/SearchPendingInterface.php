<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class SearchPendingInterface extends BaseInterface
{
    public $ProvinceCode;
    public $MunicipalityCode;
    public $BarangayCode;
    public $ClassNo;
    public $DateConductedFrom;
    public $DateConductedTo;
    public $TypeOfClass;
    public $SearchStatus;
}