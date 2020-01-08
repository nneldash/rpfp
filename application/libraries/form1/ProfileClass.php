<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form1/ProfileInterface');

class ProfileClass extends ProfileInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }

    public static function getFromVariable($variable) : ProfileInterface
    {
        if ($variable instanceof ProfileInterface) {
            return $variable;
        }
        return new Profile($variable);
    }

}
