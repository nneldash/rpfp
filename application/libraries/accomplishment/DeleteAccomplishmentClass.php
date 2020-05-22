<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('accomplishment/DeleteAccomplishmentInterface');

class DeleteAccomplishmentClass extends DeleteAccomplishmentInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }
}
