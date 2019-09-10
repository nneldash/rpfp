<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('login/PasswordsInterface');

class Passwords extends PasswordsInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
        if (!$params) {
            $this->OldPassword = BLANK;
            $this->NewPassword = BLANK;
            $this->ConfirmPassword = BLANK;
            return;
        }
        
        $this->OldPassword = $params[OLDPASSWORD];
        $this->NewPassword = $params[NEWPASSWORD];
        $this->ConfirmPassword = $params[CONFIRMPASSWORD];
    }
}
