<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class IndividualsReproductiveAgeInterface extends BaseInterface
{
    public $SubModule;
    public $Non4ps;
    public $Usapan;
    public $Pmc;
    public $H2h;
    public $ProfitedOnly;
    public $Total;
}
