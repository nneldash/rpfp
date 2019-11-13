<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('couple_list/PendingInterface');

class PendingClass extends PendingInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
    }

    public static function getFromVariable($variable) : PendingInterface
    {
        if ($variable instanceof PendingInterface) {
            return $variable;
        }
        return new PendingClass();
    }
}
