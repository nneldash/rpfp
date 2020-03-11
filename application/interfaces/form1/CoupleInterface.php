<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('form1/NameInterface');
$CI->load->iface('form1/IndividualInterface');
$CI->load->iface('form1/ModernFpUserInterface');
$CI->load->iface('form1/TraditionalFpUserInterface');

abstract class CoupleInterface extends BaseInterface
{
    /** @var int */
    public $Id;

    /** @var IndividualInterface */
    public $FirstEntry;

    /** @var IndividualInterface */
    public $SecondEntry;

    /** @var string */
    public $Address_St;

    /** @var string */
    public $Address_Brgy;

    /** @var string */
    public $Address_City;

    /** @var string */
    public $Address_HH_No;

    /** @var int */
    public $NumberOfChildren;

    /** @var ModernFpUserInterface */
    public $ModernFp;

    /** @var TraditionalFpUserInterface */
    public $TraditionalFp;

    /** @var int */
    public $FpServed;

    /** @var bool */
    public $IsActive;

    /** @var bool */
    public $IsApproved;

    abstract public function Husband() : IndividualInterface;
    abstract public function Wife() : IndividualInterface;
    abstract public static function getFromVariable($variable) : CoupleInterface;
}
