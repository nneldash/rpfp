<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('couple_list/SearchPendingInterface');

class SearchPendingClass extends SearchPendingInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
