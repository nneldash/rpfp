<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/ListBase');
$CI->load->iface('formA/FormAInterface');

abstract class ListFormAInterface extends ListBase
{
    public function __construct()
    {
        parent::__construct();
        $this->baseInterface = 'FormAInterface';
    }

    abstract public static function getFromVariable($var);
}
