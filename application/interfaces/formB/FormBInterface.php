<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('formB/lists/ListFormBMonthsInterface');

abstract class FormBInterface extends BaseInterface
{
    /** @var PeriodReportInterface */
    public $Period;
    /** @var ListFormBMonthsInterface */
    public $ListMonth;

    public $ReportID;
    public $ReportType;
    public $ReportYear;
    public $ReportCode;
    public $ReportQuarter;
    public $ReportMonth;
    public $DateProcessed;

    /** @var string */
    public $ReportNo;
    public $DateText;
    /** @var int */
    public $RegionalOffice = 0;
    /** @var int */
    public $ReportDate = 0;
    /** @var int */
    public $UnmetModern = 0;
    /** @var int */
    public $ServedModern = 0;
    /** @var int */
    public $NoIntention = 0;
    /** @var int */
    public $WithIntention = 0;
    /** @var int */
    public $ServedTraditional = 0;
    /** @var int */
    public $TotalUnmet = 0;
    /** @var int */
    public $TotalServed = 0;
}
