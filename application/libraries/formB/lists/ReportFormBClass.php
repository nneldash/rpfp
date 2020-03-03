<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formB/lists/ReportFormBInterface');

class ReportFormBClass extends ReportFormBInterface
{
    public static function getFromVariable($variable) : ReportFormBInterface
    {
        if ($variable instanceof ReportFormBInterface) {
            return $variable;
        }
        return new ReportFormBClass($variable);
    }
}
