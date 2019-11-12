<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/ServedPillsInterface');

class ServedPillsClass extends ServedPillsInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}

