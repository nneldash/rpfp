<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('common/ModernMethods');

abstract class ModernFpUserInterface extends BaseInterface
{
    /** @var int */
    public $Id;
    
    /** @var ModernMethods */
    public $MethodUsed;

    /** @var ModernMethods */
	public $IntentionToShift;
}
