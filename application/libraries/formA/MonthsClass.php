<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/MonthsInterface');
$CI->load->library('formA/lists/ListSessionsHeldClass');
$CI->load->library('formA/lists/ListIndividualsReproductiveAgeClass');
$CI->load->library('formA/lists/ListSoloCoupleDisaggregationClass');

class MonthsClass extends MonthsInterface
{
    public function __construct($params = null)
    {
        $this->ListSessionsHeld = new ListSessionsHeldClass();
        $this->ListIndividualsReproductiveAge = new ListIndividualsReproductiveAgeClass();
        $this->ListSoloCoupleDisaggregation = new ListSoloCoupleDisaggregationClass();

        parent::__construct($params);
    }
}
