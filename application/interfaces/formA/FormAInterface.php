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

    public $Class4Ps;
    public $ClassNon4Ps;
    public $ClassUsapan;
    public $ClassPMC;
    public $ClassH2H;
    public $ClassProfiled;
    public $TargetCouples;
    public $WRA4Ps;
    public $WRANon4Ps;
    public $WRAUsapan;
    public $WRAPMC;
    public $WRAH2H;
    public $WRAProfiled;
    public $SoloMale;
    public $SoloFemale;
    public $CoupleAttendee;
    public $TotalReached;
}
