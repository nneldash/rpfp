<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/ListBase');
$CI->load->iface('formA/SessionsHeldInterface');

abstract class ListSessionsHeldInterface extends ListBase
{
    public function __construct()
    {
        parent::__construct();
        $this->baseInterface = 'SessionsHeldInterface';
    }
}
