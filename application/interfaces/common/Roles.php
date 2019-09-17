<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class Roles extends BasicEnum
{
    const ENCODER = 60;
    const FOCAL_PERSON = 70;
    const DATA_MANATER = 80;
    const PMED_STAFF = 90;
    const ITDMU_STAFF = 100;
}
