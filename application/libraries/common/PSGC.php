<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('common/CodeInterface');

class PSGC extends CodeInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
