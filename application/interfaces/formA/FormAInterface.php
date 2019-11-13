<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('formA/PeriodReportInterface');
$CI->load->iface('formA/lists/ListMonthsInterface');

abstract class FormAInterface extends BaseInterface
{
    /** @var PeriodReportInterface */
    public $Period;
    /** @var ListMonthsInterface */
    public $ListMonth;

    public $ReportID;
    public $ReportYear;
    public $ReportMonth;
    public $DateProcessed;
}
