<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formA/lists/ListFormAInterface');

class ListFormA extends ListFormAInterface
{
    public static function getFromVariable($variable) : ListFormAInterface
    {
        if ($variable instanceof ListFormAInterface) {
            return $variable;
        }
        return new ListFormA();
    }

}
