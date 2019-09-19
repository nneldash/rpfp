<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('formA/lists/ListSoloAttendeesInterface');

abstract class SoloCoupleDisaggregationInterface extends BaseInterface
{
    /** @var ListSoloAttendeesInterface */
    public $ListSoloAttendees;
    public $CoupleAttendees;
}
