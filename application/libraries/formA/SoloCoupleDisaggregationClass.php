<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/SoloCoupleDisaggregationInterface');
$CI->load->library('formA/lists/ListSoloAttendeesClass');

class SoloCoupleDisaggregationClass extends SoloCoupleDisaggregationInterface
{
    public function __construct($params = null)
    {
        $this->ListSoloAttendees = new ListSoloAttendeesClass();

        parent::__construct($params);
    }
}
