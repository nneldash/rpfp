<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('form/NameInterface');

abstract class CoupleInterface extends BaseInterface
{
    /** @var NameInterface */
    public $Name;
    public $Method;
    public $ReasonForUsing;
    public $IntentionToUse;
}
