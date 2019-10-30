<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class PendingInterface extends BaseInterface
{
    public $RpfpClass;
    public $TypeClass;
    public $OthersSpecify;
    public $Barangay;
    public $ClassNo;
    public $DateConduct;
    public $LastName;
    public $FirstName;
}
