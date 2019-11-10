<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class AccomplishmentInterface extends BaseInterface
{
    public $ReportNo;
    public $ReportYear;
    public $ReportMonth;
    public $DateProcessed;
}
