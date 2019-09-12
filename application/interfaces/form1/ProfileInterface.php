<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('form1/AddressInterface');

abstract class ProfileInterface extends BaseInterface
{
    public $Sex;
	public $CivilStatus;
	public $Age;
	public $EducationalAttainment;
}
