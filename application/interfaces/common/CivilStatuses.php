<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class CivilStatuses extends BasicEnum
{
    const MARRIED = 1;
    const SINGLE = 2;
    const WIDOW = 3;
    const SEPARATED = 4;
    const LIVE_IN = 5;
}
