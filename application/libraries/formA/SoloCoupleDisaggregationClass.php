<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/SoloCoupleDisaggregationInterface');

class SoloCoupleDisaggregationClass extends SoloCoupleDisaggregationInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
