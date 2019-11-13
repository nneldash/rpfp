<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/ReportBase');
$CI->load->iface('accomplishment/AccomplishmentInterface');

abstract class ReportAccomplishmentInterface extends ReportBase
{
    public function __construct()
    {
        parent::__construct();
        $this->baseInterface = 'AccomplishmentInterface';
    }
}
