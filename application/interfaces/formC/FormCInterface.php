<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('formC/lists/ListFormCMonthsInterface');

abstract class FormCInterface extends BaseInterface
{
    /** @var ListFormCMonthsInterface */
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
    public $ReportDate = 0;
    /** @var int */
    public $RegionalOffice = 0;
    /** @var int */
    public $ServedCondom = 0;
    /** @var int */
    public $ServedIUD = 0;
    /** @var int */
    public $ServedPills = 0;
    /** @var int */
    public $ServedInjectables = 0;
    /** @var int */
    public $ServedNSV = 0;
    /** @var int */
    public $ServedBTL = 0;
    /** @var int */
    public $ServedImplant = 0;
    /** @var int */
    public $ServedCMM = 0;
    /** @var int */
    public $ServedBBT = 0;
    /** @var int */
    public $ServedSymptoThermal = 0;
    /** @var int */
    public $ServedSDM = 0;
    /** @var int */
    public $ServedLAM = 0;
    /** @var int */
    public $TotalServed = 0;
}
