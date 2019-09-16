<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('common/PSGCInterface');

class PSGC extends PSGCInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
