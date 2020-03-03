<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formB/lists/ListFormBInterface');

class ListFormBClass extends ListFormBInterface
{
    public static function getFromVariable($variable) : ListFormBInterface
    {
        if ($variable instanceof ListFormAInterface) {
            return $variable;
        }
        return new ListFormBClass();
    }

}
