<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/FormAInterface');
$CI->load->library('formA/PeriodReportClass');
$CI->load->library('formA/lists/ListMonthsClass');

class FormAClass extends FormAInterface
{
    public function __construct($params = null)
    {
        $this->Period = new PeriodReportClass();
        $this->ListMonth = new ListMonthsClass();

        parent::__construct($params);
    }

    public static function getFormFromVariable($form) : FormAInterface
    {
        if ($form instanceof FormAInterface) {
            return $form;
        }
        return new FormClass($form);
    }
}
