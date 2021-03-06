<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/ListBase');
$CI->load->iface('formB/FormBInterface');

abstract class ListFormBInterface extends ListBase
{
    public function __construct()
    {
        parent::__construct();
        $this->baseInterface = 'FormBInterface';
    }

    abstract public static function getFromVariable($var);
}
