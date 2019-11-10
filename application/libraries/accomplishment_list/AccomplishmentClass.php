<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('accomplishment_list/AccomplishmentInterface');

class AccomplishmentClass extends AccomplishmentInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
