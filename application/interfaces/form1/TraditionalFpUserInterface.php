<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('common/TraditionalMethods');
$CI->load->iface('common/ReasonsForUsing');

abstract class TraditionalFpUserInterface extends BaseInterface
{
	/** @var TraditionalMethods */
	public $Type;
	
	/** @var TraditionalStatuses */
	public $Status;

	/** @var ReasonsForUsing */
	public $ReasonForUse;
}
