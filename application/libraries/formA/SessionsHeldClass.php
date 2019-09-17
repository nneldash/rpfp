<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/SessionsHeldInterface');

class SessionsHeldClass extends SessionsHeldInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
