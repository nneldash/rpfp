<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

class DbInstance extends BaseInterface
{
    public $database;
    public $connected;

    public static function getFromVariable($variable)
    {
        if ($variable instanceof DbInstance) {
            return $variable;
        }
        return new DbInstance($variable);
    }
}
