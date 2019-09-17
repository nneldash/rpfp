<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('formA/lists/ListSessionsHeldInterface');
$CI->load->iface('formA/lists/ListIndividualsReproductiveAgeInterface');
$CI->load->iface('formA/lists/ListSoloCoupleDisaggregationInterface');

abstract class MonthsInterface extends BaseInterface
{
    public $Month;
    /** @var ListSessionsHeldInterface */
    public $ListSessionsHeld;
    /** @var ListIndividualsReproductiveAgeInterface */
    public $ListIndividualsReproductiveAge;
    /** @var ListSoloCoupleDisaggregationInterface */
    public $ListSoloCoupleDisaggregation;
}
