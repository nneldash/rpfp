<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('formC/lists/ListFormCInterface');

class ListFormC extends ListFormCInterface
{
    public static function getFromVariable($variable) : ListFormCInterface
    {
        if ($variable instanceof ListFormCInterface) {
            return $variable;
        }
        return new ListFormC();
    }

}
