<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class Sexes extends BasicEnum
{
    const MALE = 1;
    const FEMALE = 2;
}
