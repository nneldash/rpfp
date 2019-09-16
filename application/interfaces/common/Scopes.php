<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class Scopes extends BasicEnum
{
    const NATIONAL = 50;
    const REGIONAL = 40;
    const PROVINCIAL = 30;
    const CITYWIDE = 20;
}
