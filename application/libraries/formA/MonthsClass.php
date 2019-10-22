<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/MonthsInterface');
$CI->load->library('formA/SessionsHeldClass');
$CI->load->library('formA/IndividualsReproductiveAgeClass');
$CI->load->library('formA/SoloCoupleDisaggregationClass');

class MonthsClass extends MonthsInterface
{
    public function __construct($params = null)
    {
        $this->SessionsHeld = new SessionsHeldClass();
        $this->IndividualsReproductiveAge = new IndividualsReproductiveAgeClass();
        $this->SoloCoupleDisaggregation = new SoloCoupleDisaggregationClass();

        parent::__construct($params);
    }
}
