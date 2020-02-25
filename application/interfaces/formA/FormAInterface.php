<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('formA/PeriodReportInterface');
$CI->load->iface('formA/lists/ListFormAMonthsInterface');

abstract class FormAInterface extends BaseInterface
{
    /** @var PeriodReportInterface */
    public $Period;
    /** @var ListFormAMonthsInterface */
    public $ListMonth;

    public $ReportID;
    public $ReportYear;
    public $ReportMonth;
    public $DateProcessed;

    /** @var string */
    public $DateText;
    /** @var int */    
    public $TotalSessions = 0;
    /** @var int */
    public $TotalWRA = 0;

    /** @var int */
    public $Class4Ps = 0;
    /** @var int */
    public $ClassNon4Ps = 0;
    /** @var int */
    public $ClassUsapan = 0;
    /** @var int */
    public $ClassPMC = 0;
    /** @var int */
    public $ClassH2H = 0;
    /** @var int */
    public $ClassProfiled = 0;
    /** @var int */
    public $TargetCouples = 0;
    /** @var int */
    public $WRA4Ps = 0;
    /** @var int */
    public $WRANon4Ps = 0;
    /** @var int */
    public $WRAUsapan = 0;
    /** @var int */
    public $WRAPMC = 0;
    /** @var int */
    public $WRAH2H = 0;
    /** @var int */
    public $WRAProfiled = 0;
    /** @var int */
    public $SoloMale = 0;
    /** @var int */
    public $SoloFemale = 0;
    /** @var int */
    public $CoupleAttendee = 0;
    /** @var int */
    public $TotalReached = 0;
}
