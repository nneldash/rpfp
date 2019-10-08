<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class TraditionalMethods extends BasicEnum
{
    const WITHDRAWAL = 1;
    const RHYTHM = 2;
    const CALENDAR = 3;
    const ABSTINENCE = 4;
    const HERBAL = 5;
    const NO_METHOD = 6;
}
