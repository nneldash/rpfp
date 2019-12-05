<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('login/UserCredentialsInterface');

class BasicUserCredentials extends UserCredentialsInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
        if (!$params) {
            $this->UserName = BLANK;
            $this->Password = BLANK;
            return;
        }
        
        $this->UserName = $params[USERNAME];
        $this->Password = $params[USERPASSWORD];
    }

    
    public function validate() : bool
    {
        if (!$this->UserName || !$this->Password || trim($this->UserName) == '' || trim($this->Password) == '') {
            return false;
        }

        return true;
    }

    public static function getFromVariable($variable) : UserCredentialsInterface
    {
        if ($variable instanceof UserCredentialsInterface) {
            return $variable;
        }
        return new BasicUserCredentials();
    }
}
