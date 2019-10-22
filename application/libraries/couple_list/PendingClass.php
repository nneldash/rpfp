<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('couple_list/PendingInterface');

class PendingClass extends PendingInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
