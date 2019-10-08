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
    /** @var IndividualInterface */
    public $FirstEntry;

    /** @var IndividualInterface */
    public $SecondEntry;

    /** @var string */
    public $Address;

    /** @var int */
    public $NumberOfChildren;

    /** @var ModernFpUserInterface */
    public $ModernFp;

    /** @var TraditionalFpUserInterface */
    public $TraditionalFp;

    abstract public function Wife() : IndividualInterface;
    abstract public function Husband() : IndividualInterface;
}
