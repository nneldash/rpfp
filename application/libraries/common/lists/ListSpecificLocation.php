<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('common/lists/ListLocationInterface');

class ListSpecificLocation extends ListLocationInterface
{
    public static function getFromVariable($variable)
    {
        if ($variable instanceof ListLocationInterface) {
            return $variable;
        }
        return new ListSpecificLocation();
    }

}
