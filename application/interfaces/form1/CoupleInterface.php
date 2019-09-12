<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('form1/NameInterface');
// $CI->load->iface('form/AddressInterface');
$CI->load->iface('form1/lists/ListHusbandInterface');
$CI->load->iface('form1/lists/ListWifeInterface');
$CI->load->iface('form1/lists/ListModernFpUserInterface');
$CI->load->iface('form1/lists/ListTraditionalFpUserInterface');

abstract class CoupleInterface extends BaseInterface
{
    /** @var ListHusbandInterface */
    public $ListHusband;
    /** @var ListWifeInterface */
    public $ListWife;
    public $Address;
    public $NumberOfChildren;
    /** @var ListModernFpUserInterface */
    public $ListModernFp;
    /** @var ListTraditionalFpUserInterface */
    public $ListTraditionalFp;
}
