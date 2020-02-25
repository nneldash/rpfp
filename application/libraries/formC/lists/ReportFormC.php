<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/lists/ReportFormCInterface');

class ReportFormC extends ReportFormCInterface
{
    public static function getFromVariable($variable) : ReportFormCInterface
    {
        if ($variable instanceof ReportFormCInterface) {
            return $variable;
        }
        return new ReportFormC($variable);
    }
}
