<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class PasswordsInterface extends BaseInterface
{
    public $OldPassword;
    public $NewPassword;
    public $ConfirmPassword;
    
    // abstract public function validate();
}