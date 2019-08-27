<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('form/SeminarInterface');
$CI->load->iface('form/lists/ListCoupleInterface');
$CI->load->iface('form/ProfileInterface');
$CI->load->iface('form/ModernFpUserInterface');
$CI->load->iface('form/TraditionalFpUserInterface');

abstract class FormInterface extends BaseInterface
{
	/** @var SeminarInterface */
    public $Seminar;
    /** @var ListCoupleInterface */
    public $ListCouple;
    /** @var ProfileInterface */
    public $Profile;
    /** @var ModernFpUserInterface */
    public $ModernFpUser;
    /** @var TraditionalFpUserInterface */
    public $TraditionalFpUser;
}
