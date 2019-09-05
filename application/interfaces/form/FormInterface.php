<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('form/SeminarInterface');
$CI->load->iface('form/lists/ListCoupleInterface');
$CI->load->iface('form/lists/ListProfileInterface');
$CI->load->iface('form/lists/ListModernFpUserInterface');
$CI->load->iface('form/TraditionalFpUserInterface');

abstract class FormInterface extends BaseInterface
{
	/** @var SeminarInterface */
    public $Seminar;
    /** @var ListCoupleInterface */
    public $ListCouple;
    // /** @var ListProfileInterface */
    // public $ListProfile;
    // /** @var ListModernFpUserInterface */
    // public $ListModernFpUser;
    // /** @var TraditionalFpUserInterface */
    // public $TraditionalFpUser;
}
