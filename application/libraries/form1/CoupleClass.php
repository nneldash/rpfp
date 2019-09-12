<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form1/CoupleInterface');
$CI->load->library('form1/NameClass');
$CI->load->library('form1/lists/ListHusbandClass');
$CI->load->library('form1/lists/ListWifeClass');
$CI->load->library('form1/lists/ListModernFpUserClass');
$CI->load->library('form1/lists/ListTraditionalFpUserClass');

class CoupleClass extends CoupleInterface
{
    public function __construct($params = null)
    {
        $this->ListHusband = new ListHusbandClass();
        $this->ListWife = new ListWifeClass();
        $this->ListModernFp = new ListModernFpUserClass();
        $this->ListTraditionalFp = new ListTraditionalFpUserClass();

        parent::__construct($params);
    }
}
    