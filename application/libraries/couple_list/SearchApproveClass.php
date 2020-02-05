<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('couple_list/SearchApproveInterface');

class SearchApproveClass extends SearchApproveInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
