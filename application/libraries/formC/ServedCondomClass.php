<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/ServedCondomInterface');

class ServedCondomClass extends ServedCondomInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
