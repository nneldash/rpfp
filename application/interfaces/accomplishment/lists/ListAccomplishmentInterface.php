<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/ListBase');
$CI->load->iface('accomplishment/AccomplishmentInterface');

abstract class ListAccomplishmentInterface extends ListBase
{
    public function __construct()
    {
        parent::__construct();
        $this->baseInterface = 'AccomplishmentInterface';
    }
}
