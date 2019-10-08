<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('formB/lists/ListMonthsInterface');

abstract class FormBInterface extends BaseInterface
{
    /** @var ListMonthsInterface */
    public $ListMonth;
}
