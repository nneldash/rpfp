<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form1/SeminarInterface');

class SeminarClass extends SeminarInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
    