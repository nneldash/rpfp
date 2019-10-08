<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class ModernMethods extends BasicEnum
{
    const CONDOM = 1;
    const IUD = 2;
    const PILLS = 3;
    const INJECTABLE = 4;
    const VASECTOMY = 5;
    const TUBAL_LIGATION = 6;
    const IMPLANT = 7;
    const CMM_BILLINGS = 8;
    const BBT = 9;
    const SYMPTO_THERMAL = 10;
    const SDM = 11;
    const LAM = 12;
}
