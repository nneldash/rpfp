<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/ListBase');
$CI->load->iface('formB/CouplesUsingTraditionalFpInterface');

abstract class ListCouplesUsingTraditionalFpInterface extends ListBase
{
    public function __construct()
    {
        parent::__construct();
        $this->baseInterface = 'CouplesUsingTraditionalFpInterface';
    }
}
