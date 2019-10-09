<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class TraditionalStatuses extends BasicEnum
{
    const EXPRESSING_INTENTION = 1;
    const UNDECIDED = 2;
    const CURRENTLY_PREGNANT = 3;
    const NO_INTENTION = 4;
}
