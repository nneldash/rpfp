<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('common/PSGCInterface');
$CI->load->iface('common/Periods');

abstract class PeriodReportInterface extends BaseInterface
{
    /** @var Periods */
    public $MonthsPeriod;

    /** @var PSGCInterface */
    public $RegionalOffice;
}
