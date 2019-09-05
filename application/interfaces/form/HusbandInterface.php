<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('form/NameInterface');

abstract class HusbandInterface extends BaseInterface
{
    /** @var NameInterface */
    public $Name;
    public $Sex;
	public $CivilStatus;
	public $Age;
    public $EducationalAttainment;
    public $HasAttended;
}
