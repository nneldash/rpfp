<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('form/NameInterface');
// $CI->load->iface('form/AddressInterface');
$CI->load->iface('form/lists/ListModernFpUserInterface');
$CI->load->iface('form/lists/ListTraditionalFpUserInterface');

abstract class CoupleInterface extends BaseInterface
{
    /** @var NameInterface */
    public $Husband;
    /** @var NameInterface */
    public $Wife;
    // /** @var AddressInterface */
    public $Address;
    public $NumberOfChildren;
    /** @var ListModernFpUserInterface */
    public $ListModernFp;
    /** @var ListTraditionalFpUserInterface */
    public $ListTraditionalFp;
}
