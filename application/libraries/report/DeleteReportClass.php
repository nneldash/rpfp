<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('report/DeleteReportInterface');

class DeleteReportClass extends DeleteReportInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }

    public static function getFromVariable($variable) : DeleteReportInterface
    {
        if ($variable instanceof DeleteReportInterface) {
            return $variable;
        }
        return new DeleteReportClass();
    }
}
