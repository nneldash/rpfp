<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('form1/NameInterface');

abstract class ServiceSlipInterface extends BaseInterface
{
    /** @var int */
    public $Id;
    
    /** @var DateTime */
    public $DateOfVisit;
    
    /** @var string */
    public $ClientName;

    /** @var string */
    public $ClientAddress;

    /** @var string */
    public $MethodUsed;

    /** @var string */
    public $CounseledToUse;

    /** @var string */
    public $OtherReasons;

    /** @var DateTime */
    public $DateOfMethod;

    /** @var string */
    public $ClientAdvised;

    /** @var string */
    public $ReferralFacility;

    /** @var NameInterface */
    public $Name;
}
