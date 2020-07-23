<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class PercentageYearInterface extends BaseInterface
{
    public $GraphicId;
    public $ReportYear;
    public $EncodedTarget;
    public $EncodedReached;
    public $TargetReached;
   
}
