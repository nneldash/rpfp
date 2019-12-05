<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class UserCredentialsInterface extends BaseInterface
{
    public $UserName;
    public $Password;
    
    abstract public function validate() : bool;
    abstract public static function getFromVariable($variable) : UserCredentialsInterface;
}
