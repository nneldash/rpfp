<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class DuplicateIndividualInterface extends BaseInterface
{
    public $CheckDetails;
    public $CouplesId;
    public $ActiveStatus;
    public $W_couplesId;
    public $W_Last;
    public $W_First;
    public $W_Bday;
    public $W_Sex;
}
