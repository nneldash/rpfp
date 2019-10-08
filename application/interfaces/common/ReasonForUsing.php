<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BasicEnum');

abstract class ReasonForUsing extends BasicEnum
{
    const SPACING = 1;
    const LIMITING = 2;
    const ACHIEVING = 3;
}
