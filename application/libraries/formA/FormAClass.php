<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/FormAInterface');
$CI->load->library('formA/PeriodReportClass');
$CI->load->library('formA/lists/ListFormAMonthsClass');

class FormAClass extends FormAInterface
{
    public function __construct($params = null)
    {
        $this->Period = new PeriodReportClass();
        $this->ListMonth = new ListFormAMonthsClass();

        parent::__construct($params);
    }

    public static function getFromVariable($variable) : FormAInterface
    {
        if ($variable instanceof FormAInterface) {
            return $variable;
        }
        return new FormAClass($variable);
    }

    public function getTotalSessions()
    {
        return (int)$this->Class4Ps +
                (int)$this->ClassNon4Ps +
                (int)$this->ClassUsapan +
                (int)$this->ClassPMC +
                (int)$this->ClassH2H +
                (int)$this->ClassProfiled
        ;
    }

    public function getTotalWRA()
    {
        return (int)$this->WRA4Ps +
                (int)$this->WRANon4Ps +
                (int)$this->WRAUsapan +
                (int)$this->WRAPMC +
                (int)$this->WRAH2H +
                (int)$this->WRAProfiled
        ;
    }

}
