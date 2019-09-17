<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/ListBase');
$CI->load->iface('formA/MonthsInterface');

abstract class ListMonthsInterface extends ListBase
{
    public function __construct()
    {
        parent::__construct();
        $this->baseInterface = 'MonthsInterface';
    }
}
