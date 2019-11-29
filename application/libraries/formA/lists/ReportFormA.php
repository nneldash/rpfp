<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/lists/ReportFormAInterface');

class ReportFormA extends ReportFormAInterface
{
    public static function getFromVariable($variable) : ReportFormAInterface
    {
        if ($variable instanceof ReportFormAInterface) {
            return $variable;
        }
        return new ReportFormA($variable);
    }
}
