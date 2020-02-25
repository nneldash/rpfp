<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('formA/SessionsHeldInterface');
$CI->load->iface('formA/IndividualsReproductiveAgeInterface');
$CI->load->iface('formA/SoloCoupleDisaggregationInterface');

abstract class FormAMonthsInterface extends BaseInterface
{
    public $Month;

    /** @var SessionsHeldInterface */
    public $SessionsHeld;

    /** @var IndividualsReproductiveAgeInterface */
    public $IndividualsReproductiveAge;
    
    /** @var SoloCoupleDisaggregationInterface */
    public $SoloCoupleDisaggregation;
}
