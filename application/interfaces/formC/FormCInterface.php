<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('formC/lists/ListMonthsInterface');

abstract class FormCInterface extends BaseInterface
{
    /** @var ListMonthsInterface */
    public $ListMonth;
    
    public $ReportNo;
    public $ReportYear;
    public $ReportMonth;
    public $DateProcessed;
}
