<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('form1/SeminarInterface');
$CI->load->iface('form1/lists/ListCoupleInterface');
$CI->load->iface('form1/lists/ListProfileInterface');
$CI->load->iface('form1/lists/ListModernFpUserInterface');
$CI->load->iface('form1/TraditionalFpUserInterface');

abstract class FormInterface extends BaseInterface
{
	/** @var SeminarInterface */
    public $Seminar;
    
    /** @var ListCoupleInterface */
    public $ListCouple;
}
