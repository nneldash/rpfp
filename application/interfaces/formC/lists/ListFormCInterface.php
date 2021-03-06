<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/ListBase');
$CI->load->iface('formC/FormCInterface');

abstract class ListFormCInterface extends ListBase
{
    public function __construct()
    {
        parent::__construct();
        $this->baseInterface = 'FormCInterface';
    }

    abstract public static function getFromVariable($var);
}
