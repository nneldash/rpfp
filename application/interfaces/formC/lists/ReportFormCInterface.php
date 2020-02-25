<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/ReportBase');
$CI->load->iface('formC/FormCInterface');

abstract class ReportFormCInterface extends ReportBase
{
    public function __construct()
    {
        parent::__construct();
        $this->baseInterface = 'FormCInterface';
    }
}
