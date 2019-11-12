<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/ServedImplantInterface');

class ServedImplantClass extends ServedImplantInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}

