<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('couple_list/DuplicateMaleInterface');

class DuplicateMaleClass extends DuplicateMaleInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
