<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class AllowedSeminarTypes extends BasicEnum
{
    const FOUR_PS = 1;
    const FAITHBASED_ORG = 2;
    const PMC = 3;
    const USAPAN = 4;
    const HOUSE_2_HOUSE = 5;
    const PROFILE_ONLY = 6;
    const OTHERS = 7;
}
