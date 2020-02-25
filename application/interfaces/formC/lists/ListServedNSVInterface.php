<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/ListBase');
$CI->load->iface('formC/ServedNSVInterface');

abstract class ListServedNSVInterface extends ListBase
{
    public function __construct()
    {
        parent::__construct();
        $this->baseInterface = 'ServedNSVInterface';
    }
}
