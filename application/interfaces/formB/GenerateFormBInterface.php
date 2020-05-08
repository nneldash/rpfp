<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class GenerateFormBInterface extends BaseInterface
{
    public $ReportType;
    public $ReportYear;
    public $ReportCode;
    public $ReportQuarter;
    public $ReportMonth;
}
