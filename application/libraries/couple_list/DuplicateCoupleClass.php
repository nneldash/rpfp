<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('couple_list/DuplicateCoupleInterface');

class DuplicateCoupleClass extends DuplicateCoupleInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
