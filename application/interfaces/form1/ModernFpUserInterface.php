<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class ModernFpUserInterface extends BaseInterface
{
    /** @var ModernMethods */
    public $MethodUsed;

    /** @var ModernMethods */
	public $IntentionToShift;
}
