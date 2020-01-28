<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class DuplicateCoupleInterface extends BaseInterface
{
    public $CheckDetails;
    public $CouplesId;
    public $ActiveStatus;
    public $H_Last;
    public $H_First;
    public $H_Ext;
    public $H_Bday;
    public $H_Sex;
    public $W_couplesId;
    public $W_Last;
    public $W_First;
    public $W_Bday;
    public $W_Sex;
}
