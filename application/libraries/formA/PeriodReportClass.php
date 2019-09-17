<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/PeriodReportInterface');

class PeriodReportClass extends PeriodReportInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
