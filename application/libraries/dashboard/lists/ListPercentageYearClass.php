<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('dashboard/PercentageYearInterface');

class ListPercentageYearClass extends PercentageYearInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
